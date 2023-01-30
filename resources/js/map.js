import init from "./yandex-map/map";

$(document).ready(function () {
    ymaps.ready(init);
}).on("pjax:complete", function () {
    init();
});