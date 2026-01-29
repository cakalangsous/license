<script setup>
import { ref, watch } from "vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        default: "",
    },
    error: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "Write something...",
    },
    height: {
        type: String,
        default: "200px",
    },
});

const emit = defineEmits(["update:modelValue"]);

const content = ref(props.modelValue);

// Watch for external changes to modelValue
watch(
    () => props.modelValue,
    (newVal) => {
        if (newVal !== content.value) {
            content.value = newVal;
        }
    }
);

// Emit changes
const onUpdate = (value) => {
    emit("update:modelValue", value);
};

// Quill toolbar options
const toolbarOptions = [
    ["bold", "italic", "underline", "strike"],
    ["blockquote", "code-block"],
    [{ header: 1 }, { header: 2 }],
    [{ list: "ordered" }, { list: "bullet" }],
    [{ indent: "-1" }, { indent: "+1" }],
    [{ size: ["small", false, "large", "huge"] }],
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
    [{ color: [] }, { background: [] }],
    [{ align: [] }],
    ["link", "image"],
    ["clean"],
];
</script>

<template>
    <div class="form-group">
        <label
            v-if="label"
            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ label }}
        </label>
        <div
            class="quill-wrapper"
            :class="{ 'quill-error': error }"
            :style="{ '--editor-height': height }"
        >
            <QuillEditor
                v-model:content="content"
                theme="snow"
                content-type="html"
                :toolbar="toolbarOptions"
                :placeholder="placeholder"
                @update:content="onUpdate"
            />
        </div>
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<style>
.quill-wrapper {
    --editor-height: 200px;
}

/* Base light mode styles */
.quill-wrapper .ql-toolbar.ql-snow {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    background-color: #f9fafb;
    border-color: #d1d5db;
}

.quill-wrapper .ql-container.ql-snow {
    min-height: var(--editor-height);
    font-size: 1rem;
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
    background-color: #ffffff;
    border-color: #d1d5db;
}

.quill-wrapper .ql-editor {
    min-height: var(--editor-height);
}

/* Dark mode styles - using :global to ensure they apply */
:root.dark .quill-wrapper .ql-toolbar.ql-snow,
.dark .quill-wrapper .ql-toolbar.ql-snow {
    background-color: #374151 !important;
    border-color: #4b5563 !important;
}

:root.dark .quill-wrapper .ql-container.ql-snow,
.dark .quill-wrapper .ql-container.ql-snow {
    background-color: #1f2937 !important;
    border-color: #4b5563 !important;
    color: #ffffff !important;
}

:root.dark .quill-wrapper .ql-editor,
.dark .quill-wrapper .ql-editor {
    color: #ffffff !important;
}

:root.dark .quill-wrapper .ql-editor.ql-blank::before,
.dark .quill-wrapper .ql-editor.ql-blank::before {
    color: #9ca3af !important;
}

/* Toolbar icons in dark mode */
:root.dark .quill-wrapper .ql-snow .ql-stroke,
.dark .quill-wrapper .ql-snow .ql-stroke {
    stroke: #d1d5db !important;
}

:root.dark .quill-wrapper .ql-snow .ql-fill,
.dark .quill-wrapper .ql-snow .ql-fill {
    fill: #d1d5db !important;
}

:root.dark .quill-wrapper .ql-snow .ql-picker,
.dark .quill-wrapper .ql-snow .ql-picker {
    color: #d1d5db !important;
}

:root.dark .quill-wrapper .ql-snow .ql-picker-label,
.dark .quill-wrapper .ql-snow .ql-picker-label {
    color: #d1d5db !important;
}

:root.dark .quill-wrapper .ql-snow .ql-picker-options,
.dark .quill-wrapper .ql-snow .ql-picker-options {
    background-color: #374151 !important;
    border-color: #4b5563 !important;
}

:root.dark .quill-wrapper .ql-snow .ql-picker-item,
.dark .quill-wrapper .ql-snow .ql-picker-item {
    color: #d1d5db !important;
}

:root.dark .quill-wrapper .ql-snow .ql-picker-item:hover,
.dark .quill-wrapper .ql-snow .ql-picker-item:hover {
    color: #ffffff !important;
}

/* Toolbar button hover in dark mode */
:root.dark .quill-wrapper .ql-snow.ql-toolbar button:hover,
:root.dark .quill-wrapper .ql-snow .ql-toolbar button:hover,
.dark .quill-wrapper .ql-snow.ql-toolbar button:hover,
.dark .quill-wrapper .ql-snow .ql-toolbar button:hover {
    color: #ffffff !important;
}

:root.dark .quill-wrapper .ql-snow.ql-toolbar button:hover .ql-stroke,
:root.dark .quill-wrapper .ql-snow .ql-toolbar button:hover .ql-stroke,
.dark .quill-wrapper .ql-snow.ql-toolbar button:hover .ql-stroke,
.dark .quill-wrapper .ql-snow .ql-toolbar button:hover .ql-stroke {
    stroke: #ffffff !important;
}

:root.dark .quill-wrapper .ql-snow.ql-toolbar button:hover .ql-fill,
:root.dark .quill-wrapper .ql-snow .ql-toolbar button:hover .ql-fill,
.dark .quill-wrapper .ql-snow.ql-toolbar button:hover .ql-fill,
.dark .quill-wrapper .ql-snow .ql-toolbar button:hover .ql-fill {
    fill: #ffffff !important;
}

/* Active button state in dark mode */
:root.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active,
:root.dark .quill-wrapper .ql-snow .ql-toolbar button.ql-active,
.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active,
.dark .quill-wrapper .ql-snow .ql-toolbar button.ql-active {
    color: #60a5fa !important;
}

:root.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active .ql-stroke,
.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active .ql-stroke {
    stroke: #60a5fa !important;
}

:root.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active .ql-fill,
.dark .quill-wrapper .ql-snow.ql-toolbar button.ql-active .ql-fill {
    fill: #60a5fa !important;
}

/* Error state */
.quill-error .ql-container.ql-snow {
    border-color: rgb(239, 68, 68) !important;
}

.quill-error .ql-toolbar.ql-snow {
    border-color: rgb(239, 68, 68) !important;
}
</style>
