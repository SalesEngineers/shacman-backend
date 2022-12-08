document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('#has-many-characteristics');
    const btn = container.querySelector('.add');

    let selects = [...container.querySelectorAll('select')];

    const onChange = (e) => {
        console.log(e.target.value)
    };

    btn.addEventListener("click", function (e) {
        setTimeout(() => {
            const select = container.querySelector('.has-many-characteristics-form:last-child select');
            const remove = container.querySelector('.has-many-characteristics-form:last-child .remove');
            const onRemove = () => {
                selects = selects.filter(s => s !== select);
                $(select).off("change", onChange);
                select.removeEventListener("change", onChange);
                remove.removeEventListener("click", onRemove);
            };

            remove.addEventListener("click", onRemove);

            if (select) {
                $(select).on("change", onChange);
                selects.push(select)
            }
        });
    });

    selects.forEach(select => {
        $(select).on("change", onChange);
    })
});
