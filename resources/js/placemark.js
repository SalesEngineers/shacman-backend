/*global ymaps*/
const Placemark = (function () {
    var _instance,
        _placemark;

    function Placemark(coords, properties, options) {
        coords = coords || [0, 0];
        properties = properties || {};
        options = options || {};

        if (_instance) {
            this.setCoordinates(coords);
            return _instance;
        }

        _instance = this;

        this.address = '';
        _placemark = new ymaps.Placemark(coords, properties, options);
    }

    Placemark.prototype = {
        getPlacemark: function () {
            return _placemark;
        },
        setCoordinates: function (coords) {
            _placemark.geometry.setCoordinates(coords);
        },
        getCoordinates: function () {
            return _placemark.geometry.getCoordinates();
        },
        setAddress: function (coords) {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                _placemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(", "),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });

                this.address = firstGeoObject.getAddressLine();
            });
        },
        getAddress: function () {
            return this.address;
        }
    };

    return Placemark;
}());

export default Placemark
