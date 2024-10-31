import Placemark from "./placemark";

const init = () => {
    if (!document.querySelector('#map')) return;

    let coordsEl = document.querySelector('input[name="coords"]');
    let centerEl = document.querySelector('input[name="center"]');
    const zoom = document.querySelector('input[name="zoom"]');
        
    let placemarks = [];
    let selectedPlacemark = null;

    const updateCoords = () => {
        let coords = [];

        placemarks.forEach(function (placemark) {
            coords.push(placemark.getCoordinates());
        })

        coordsEl.value = JSON.stringify(coords);
    }

    let center = [55.75201801312925, 37.621497109128285];

    try {
        if (centerEl) {
            center = JSON.parse(centerEl.value);
        }
    } catch (error) {
        center = [55.75201801312925, 37.621497109128285];
    }
    
    const map = new ymaps.Map("map", {
        center,
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

    function updateMapBounds() {
        if (placemarks.length > 0) {
            var bounds = map.geoObjects.getBounds();  // Получаем границы всех объектов на карте
            
            map.setBounds(bounds, {
                checkZoomRange: true,  // Проверяем, чтобы зум не был слишком большим
                duration: 500,  // Анимация (500 миллисекунд)
                zoomMargin: 100
            }).then(function() { 
                if(map.getZoom() > 16) map.setZoom(16);
                centerEl.value = JSON.stringify(map.getCenter());
            });
        }
    }

    button.events.add("click", function () {
        if (selectedPlacemark) {
            // Удаляем выбранную метку с карты и из массива
            map.geoObjects.remove(selectedPlacemark);
            placemarks = placemarks.filter(function (placemark) {
                return placemark.getPlacemark() !== selectedPlacemark;
            });
            selectedPlacemark = null;  // Сбрасываем выделение
            updateMapBounds();
            updateCoords();
        } else {
            alert('Выберите метку для удаления.');
        }
    });

    map.controls.add(button, {float: "right", floatIndex: 100});

    const addPlacemark = (eventCoords) => {
        let placemark = new Placemark(eventCoords, {}, { draggable: true });

        placemark.setCoordinates(eventCoords);
        placemark.setAddress(eventCoords);
        
        map.geoObjects.add(placemark.getPlacemark());
        placemarks.push(placemark);

        updateCoords();

        placemark.getPlacemark().events.add('click', function () {
            if (selectedPlacemark) {
                // Если уже есть выделенная метка, сбрасываем её стиль
                selectedPlacemark.options.set('preset', 'islands#blueIcon');
            }
            selectedPlacemark = placemark.getPlacemark();  // Устанавливаем новую выделенную метку
            selectedPlacemark.options.set('preset', 'islands#redIcon');  // Меняем её цвет для обозначения выбора
        }).add('dragend', function () {
            placemark.setAddress(placemark.getCoordinates());
            updateCoords();
        });
    }

    map.events.add("click", function (e) { 
        addPlacemark(e.get("coords"));
    });

    if (coordsEl) {
        let coords = [];

        try {
            coords = JSON.parse(coordsEl.value);

            if (coords.length && coords[0] == parseFloat(coords[0])) {
                addPlacemark(coords)
            } else if (coords.length) {
                coords.forEach(function (coords) {
                    addPlacemark(coords);
                })
            }

            setTimeout(() => updateMapBounds());
        } catch (e) {}
    }
};

export default init;
