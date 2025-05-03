$(document).ready(function () {
    $(".statement-action").on("click", function (event) {
        let action = event.target.dataset.action;
        let statementsBox = $("#statementsBox");
        let statements = statementsBox.find("input")

        if (action === "add") {
            let count = statements.length
            let newEl = $("#statement-example").clone()

            newEl.attr("placeholder", newEl.attr("placeholder") + " " + (count+1))
                .attr("type", "text")
                .removeAttr('id')

            statementsBox.append(newEl)
        } else if (action === "remove") {
            statements.last().remove();
        }
    })
});
