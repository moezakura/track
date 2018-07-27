$("#loading").show();
$.ajax({
    url: "/api/getTrackingList",
    type: "GET",
    dataType: "json",
}).done((data) => {
    let addElem = $("#tracking-list");
    data.forEach(function (value) {
        let createData = {
            "platform": value.corp,
            "status": value.status,
            "name": value.name,
            "number": value.number,
        };

        let row = createColumn("row", "");
        row.dataset.id = value.id;

        for (createKey in createData) {
            let createValue = createData[createKey];
            row.appendChild(createColumn(createKey, createValue));
        }
        let deleteColumn = createColumn("delete", "");
        deleteColumn.innerHTML = "<div>削除</div>";
        deleteColumn.dataset.id = value.id;
        row.appendChild(deleteColumn);
        addElem.append(row);
    });
}).fail((data) => {
    $("#contact-error").show().text("不明なエラーが発生しました");
}).always(() => {
    $("#loading").hide();
});


/**
 *
 * @param elemClass
 * @param text
 * @returns {HTMLDivElement}
 */
function createColumn(elemClass, text){
    let elem = document.createElement("div");
    elem.classList.add(elemClass);
    elem.innerText = text;

    return elem;
}
