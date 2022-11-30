const { initial } = require("lodash");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            animation: {
                text: "text 3s ease infinite",
            },
            keyframes: {
                text: {
                    "0%, 100%": {
                        color: initial,
                        "text-shadow": "0 0 0px",
                    },
                    "50%": {
                        //text initial color
                        color: "#FBBF24",
                        "text-shadow":
                            "0 0 1px #FBBF24, 0 0 2px #FBBF24, 0 0 5px #FBBF24, 0 0 10px #FBBF24, 0 0 15px #FBBF24, 0 0 20px #FBBF24, 0 0 25px #FBBF24",
                    },
                },
            },
        },
    },
    plugins: [require("daisyui")],
};
