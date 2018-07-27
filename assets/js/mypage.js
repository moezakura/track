$("#contact-id-search").on("submit", function (e) {
    e.preventDefault();
    $("#loading").show();
    $("#contact-error").hide();

    $.ajax({
        url: "/api/searchContactId",
        type: "GET",
        data: {
            'corp': 99,
            'number': $("#contact-id-input").val(),
        },
        dataType: "json",
    }).done((data) => {
        if (!data.yamato && !data.japanPost && !data.sagawa)
            $("#contact-error").show().text("トラッキングできる会社がありません。");
        else {
            $("#contact-id-add").show();

            if (data.yamato) $("#yamato-submit").removeClass("disable");
            else $("#yamato-submit").addClass("disable");

            if (data.sagawa) $("#sagawa-submit").removeClass("disable");
            else $("#sagawa-submit").addClass("disable");

            if (data.japanPost) $("#japan-post-submit").removeClass("disable");
            else $("#japan-post-submit").addClass("disable");
        }
    }).fail((data) => {
        $("#contact-error").show().text("不明なエラーが発生しました");
    }).always(() => {
        $("#loading").hide();
    });
});

$("#contact-error").on("click", function () {
    $(this).hide();
});

$("#yamato-submit").on("click", function (e) {
    if (!$(this).hasClass("disable")) {
        addTrack($("#contact-id-input").val(), $("#tracking-name").val(), 1);
    }
});

$("#japan-post-submit").on("click", function (e) {
    if (!$(this).hasClass("disable")) {
        addTrack($("#contact-id-input").val(), $("#tracking-name").val(), 2);
    }
});

$("#sagawa-submit").on("click", function (e) {
    if (!$(this).hasClass("disable")) {
        addTrack($("#contact-id-input").val(), $("#tracking-name").val(), 3);
    }
});

function addTrack(number, name, corp) {
    $("#loading").show();
    $("#contact-error").hide();
    $("#contact-id-add").hide();

    $.ajax({
        url: "/api/addTrack",
        type: "GET",
        data: {
            'number': number,
            'name': name,
            'corp': corp,
        },
        dataType: "json",
    }).done((data) => {
        if (!data.isSuccess) {
            $("#contact-error").show().text(data.error);
        } else {
            getTrack(data.id);
        }
    }).fail((data) => {
        $("#contact-error").show().text("不明なエラーが発生しました");
    }).always(() => {
        $("#loading").hide();
    });
}

function getTrack(id) {
    $("#loading").show();
    $.ajax({
        url: "/api/getTracking",
        type: "GET",
        data: {
            'id': id,
            'update': "true",
        },
        dataType: "json",
    }).done((data) => {
        if (!data.isSuccess) {
            $("#contact-error").show().text(data.error);
        } else {
            createColumnRow(data, $("#tracking-list"));
        }
    }).fail((data) => {
        $("#contact-error").show().text("不明なエラーが発生しました");
    }).always(() => {
        $("#loading").hide();
    });
}


function createColumnRow(value, addElem){
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
}