import "./bootstrap";
import Chart from "chart.js/auto";

const userMenuButton = document.getElementById("user-menu-button");
const userMenuList = document.getElementById("user-menu-list");

if (userMenuButton && userMenuList) {
    userMenuButton.addEventListener("click", function (e) {
        e.preventDefault();

        userMenuList.classList.toggle("hidden");
    });
}

const chartJsCanvases = document.getElementsByClassName("chartjs");

if (chartJsCanvases) {
    for (let i = 0; i < chartJsCanvases.length; i++) {
        const ctx = chartJsCanvases[i].getContext("2d");
        const rawDataPrices = JSON.parse(
            chartJsCanvases[i].getAttribute("data-prices")
        );
        let labels = [];
        let datas = [];

        for (let i = 0; i < rawDataPrices.length; i++) {
            const prices = rawDataPrices[i];
            let price = 0;

            if (prices["discount_percent"] > 0) {
                price =
                    prices["price"] -
                    (prices["price"] * prices["discount_percent"]) / 100;
            } else if (prices["discount_number"] > 0) {
                price = prices["price"] - prices["discount_number"];
            } else {
                price = prices["price"];
            }

            const date = new Date(prices["created_at"]);
            const options = {
                year: "numeric",
                month: "numeric",
                day: "numeric",
            };
            const formattedDate = new Intl.DateTimeFormat(
                "id-ID",
                options
            ).format(date);

            labels.push(formattedDate);
            datas.push(price);
        }

        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Chart Harga",
                        data: datas,
                        fill: false,
                        borderColor: "#4f39f6",
                        tension: 0.3,
                        pointBackgroundColor: "#4f39f6",
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: "top",
                    },
                    tooltip: {
                        mode: "index",
                        intersect: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: "Harga (Rp)",
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Bulan",
                        },
                    },
                },
            },
        });
    }
}
