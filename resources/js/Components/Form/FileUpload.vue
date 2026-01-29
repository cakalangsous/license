<script setup>
import { ref, computed, watch, onMounted } from "vue";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType
);

const props = defineProps({
    modelValue: {
        type: [String, Array],
        default: "",
    },
    label: {
        type: String,
        default: "Upload File",
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: "",
    },
    acceptedFileTypes: {
        type: Array,
        default: () => ["image/jpeg", "image/png", "image/jpg"],
    },
    allowedExtensions: {
        type: String,
        default: "jpg,jpeg,png,gif,webp",
    },
    maxFileSize: {
        type: Number,
        default: 5120, // 5MB in KB
    },
    // Existing files to display (for edit mode)
    existingFiles: {
        type: [String, Array],
        default: null,
    },
});

const emit = defineEmits(["update:modelValue"]);
const pond = ref(null);

// Track uploaded files for multiple mode
const uploadedFiles = ref([]);

// Initial files to display in FilePond
const initialFiles = ref([]);

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Build URL with validation parameters
const uploadUrl = computed(() => {
    const params = new URLSearchParams({
        allowed_types: props.allowedExtensions,
        max_size: props.maxFileSize.toString(),
    });
    return `/admin/temp-upload?${params.toString()}`;
});

const serverOptions = computed(() => ({
    process: {
        url: uploadUrl.value,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
        onload: (response) => {
            // Validate response - should be a short alphanumeric folder ID, not HTML
            if (response && response.length < 100 && !response.includes("<")) {
                if (props.multiple) {
                    // For multiple files, add to array
                    uploadedFiles.value.push(response);
                    emit("update:modelValue", [...uploadedFiles.value]);
                } else {
                    // For single file, emit directly
                    emit("update:modelValue", response);
                }
                return response;
            } else {
                // Invalid response (likely an error page)
                console.error(
                    "FileUpload: Invalid server response",
                    response?.substring(0, 100)
                );
                return null;
            }
        },
        onerror: (response) => {
            console.error("FileUpload: Upload error", response);
            return null;
        },
    },
    revert: {
        url: "/admin/temp-delete",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    },
    restore: "/admin/temp-restore?folder=",
    load: (source, load, error, progress, abort) => {
        // Load existing file from storage
        fetch('/storage/' + source)
            .then(response => response.blob())
            .then(load)
            .catch(err => {
                console.error('Failed to load file:', err);
                error('Failed to load file');
            });
        return { abort: () => {} };
    },
}));

// Initialize existing files on mount
onMounted(() => {
    if (props.existingFiles) {
        let files = props.existingFiles;
        
        // Parse JSON string if needed
        if (typeof files === 'string' && files.startsWith('[')) {
            try {
                files = JSON.parse(files);
            } catch (e) {
                // Single file path
                files = [files];
            }
        } else if (typeof files === 'string' && files) {
            files = [files];
        }
        
        if (Array.isArray(files) && files.length > 0) {
            // For multiple files, track them
            if (props.multiple) {
                uploadedFiles.value = [...files];
            }
            
            // Set initial files for FilePond display
            initialFiles.value = files.map(file => ({
                source: file,
                options: {
                    type: 'local',
                },
            }));
        }
    }
});

const handleProcessFile = (error, file) => {
    if (error) {
        console.error("FilePond Error:", error);
    }
};

const handleRemoveFile = (error, file) => {
    if (!error) {
        if (props.multiple) {
            // For multiple files, remove from array
            const serverId = file.serverId || file.source;
            uploadedFiles.value = uploadedFiles.value.filter(f => f !== serverId);
            emit("update:modelValue", [...uploadedFiles.value]);
        } else {
            // For single file, emit empty string
            emit("update:modelValue", "");
        }
    }
};
</script>

<template>
    <div class="form-group">
        <label
            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ label }}
        </label>
        <div :class="{ 'filepond-error': error }">
            <FilePond
                ref="pond"
                name="filepond"
                :label-idle="`Drag & Drop your ${multiple ? 'files' : 'file'} or <span class='filepond--label-action'>Browse</span>`"
                :accepted-file-types="acceptedFileTypes"
                :allow-multiple="multiple"
                :server="serverOptions"
                :files="initialFiles"
                @processfile="handleProcessFile"
                @removefile="handleRemoveFile"
                credits="false"
            />
        </div>
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<style>
/* Custom styles for FilePond to match theme if needed */
.filepond--panel-root {
    background-color: #f3f4f6;
}
.dark .filepond--panel-root {
    background-color: #374151;
}
.dark .filepond--drop-label {
    color: #9ca3af;
}

.filepond-error .filepond--panel-root {
    border: 1px solid #dc2626;
}
</style>
