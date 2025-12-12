import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/header.css",
                "resources/css/footer.css",
                "resources/css/home.css",
                "resources/css/product.css",
                "resources/css/product-items.css",
                "resources/css/productview.css",
                "resources/css/dashboard.css",
                "resources/css/order.css",
                "resources/css/createproduct.css",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
