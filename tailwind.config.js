/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#6771cf",
                    50: "#d9f5f5",
                    100: "#b3ebeb",
                    200: "#8ce1e1",
                    300: "#66d7d7",
                    400: "#40cdcd",
                    500: "#6771cf",
                    600: "#199797",
                    700: "#137171",
                    800: "#0c4c4c",
                    900: "#062626",
                },
                secondary: {
                    DEFAULT: "#6c757d",
                    50: "#f8f9fa",
                    100: "#e9ecef",
                    200: "#dee2e6",
                    300: "#ced4da",
                    400: "#adb5bd",
                    500: "#6c757d",
                    600: "#495057",
                    700: "#343a40",
                    800: "#212529",
                    900: "#131313",
                },
                success: "#198754",
                danger: "#dc3545",
                warning: "#ffc107",
                info: "#0dcaf0",
                heading: "#25396f",
                body: {
                    bg: "#f2f7ff",
                    text: "#607080",
                },
            },
            fontFamily: {
                sans: ["Nunito", "system-ui", "sans-serif"],
            },
            boxShadow: {
                card: "0 0.5rem 1rem rgba(0, 0, 0, 0.15)",
                sm: "0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)",
                lg: "0 0.75rem 3rem rgba(0, 0, 0, 0.225)",
            },
            borderRadius: {
                DEFAULT: "0.25rem",
            },
        },
    },
    plugins: [require("@tailwindcss/typography")],
};
