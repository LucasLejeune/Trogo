/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            fontFamily: {
                racing: ["'Racing Sans One'", "cursive"],
                dm: ["'DM Sans'", "sans-serif"],
                poppins: ["'Poppins'", "sans-serif"],
                zen: ["'Zen Antique Soft'", "serif"],
            },
            colors: {
                primary: "#16182F",
                secondary: "#fff6a2",
                darkblue: "#0c0d1a",
            },
        },
    },
    plugins: [],
}