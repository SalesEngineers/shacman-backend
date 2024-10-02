/*global ymaps*/
const Placemark = (function () {

    function Placemark(coords, properties, options) {
        coords = coords || [0, 0];
        properties = properties || {};
        options = options || {};
        this.address = '';
        this.placemark = new ymaps.Placemark(coords, properties, options);
    }

    Placemark.prototype = {
        getPlacemark: function () {
            return this.placemark;
        },
        setCoordinates: function (coords) {
            this.placemark.geometry.setCoordinates(coords);
        },
        getCoordinates: function () {
            return this.placemark.geometry.getCoordinates();
        },
        setAddress: function (coords) {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                this.placemark.properties
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
