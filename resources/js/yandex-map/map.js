import Placemark from "./placemark";

const init = () => {
    if (!document.querySelector('#map')) return;

    let coords = document.querySelector('input[name="coords"]');
    const zoom = document.querySelector('input[name="zoom"]');
    let center = null;

    if (coords) {
        try {
            center = JSON.parse(coords.value);
        } catch (e) {}
    }

    if (!center) {
        center = [55.75201801312925, 37.621497109128285]
    }

    const map = new ymaps.Map("map", {
        center: center,
        zoom: zoom ? parseInt(zoom.value) : 16,
        controls: ["zoomControl", "searchControl"]
    });

    map.behaviors.disable('scrollZoom');

    map.events.add('boundschange', function (e) {
        const z = e.get('newZoom');
        zoom && (zoom.value = z);
    });

    const button = new ymaps.control.Button({
        data: {
            // Текст на кнопке.
            content: "Убрать метку",
            // Текст всплывающей подсказки.
            title: "Нажмите для удаления метки с карты"
        },
        options: {
            // Зададим опции для кнопки.
            selectOnClick: false,
            maxWidth: [30, 100, 150]
        }
    });

    let placemark = new Placemark(center, {}, {
        draggable: true
    });

    button.events.add("click", function () {
        map.geoObjects.removeAll();
        placemark = null;
        coords.value = '';
    });

    map.controls.add(button, {float: "right", floatIndex: 100});

    placemark.getPlacemark().events.add('dragend', function () {
        placemark.setAddress(placemark.getCoordinates());
        coords.value = JSON.stringify(placemark.getCoordinates());
    });

    map.events.add("click", function (e) {
        const eventCoords = e.get("coords");

        if (!placemark) {
            placemark = new Placemark(eventCoords, {}, {
                draggable: true
            });

            map.geoObjects.add(placemark.getPlacemark());
        }

        placemark.setCoordinates(eventCoords);
        placemark.setAddress(eventCoords);

        coords.value = JSON.stringify(eventCoords);
    });

    const placemarkCoords = placemark.getCoordinates();

    placemark.setAddress(placemarkCoords);
    map.geoObjects.add(placemark.getPlacemark());
    map.setCenter(placemarkCoords);
};

export default init;
