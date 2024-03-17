import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

function getResource(type, filePath) {
    return "resources/" + type + "/" + filePath + "." + type;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                getResource("js", "app"),
                getResource("js", "attendance"),
                getResource("js", "salaries"),
                getResource("js", "general"),
                getResource("js", "rotations"),
                getResource("js", "scheduleInputs"),
                getResource("js", "inputs"),
                getResource("js", "rols"),
                getResource("js", "edit_rol"),
                getResource("js", "docsInput"),
                getResource("js", "imageInputC"),
                getResource("js", "imageInputU"),
                getResource("js", "dragAndDrop"),

                getResource("css", "app"),

                "resources/icons/css/all.min.css",
            ],
            refresh: true,
        }),
    ],
});
