$(document).ready(function() {
  $(".main-content-body .get-job-link-button").on("click", (event) => {
    event.preventDefault();
    let buttonTarget;

    if($(event.target).hasClass("get-job-link-button-text")) {
      buttonTarget = $(event.target).parent(); 
    } else {
      buttonTarget = $(event.target);
    }

    function copyEventHandler(event) {
      event.clipboardData.setData('text/plain', buttonTarget.attr("href"));
      event.preventDefault();
      document.removeEventListener('copy', copyEventHandler, true);
      swal("Sukses!", "The Job Link has been copied.", "success");
    }

    document.addEventListener('copy', copyEventHandler, true);
    document.execCommand('copy');
  });

  $(".main-content-body .view-detail-button").on("click", (event) => {
    let buttonTarget;

    if($(event.target).hasClass("view-detail-button-text")) {
      buttonTarget = $(event.target).parent();
    } else {
      buttonTarget = $(event.target);
    }

    const title = buttonTarget.data("title");
    const companyName = buttonTarget.data("company-name");
    const publicationDate = buttonTarget.data("publication-date").substring(0, 10);
    const jobType = buttonTarget.data("job-type") || "-";
    const hiringFrom = buttonTarget.data("hiring-from") || "-";
    const salary = buttonTarget.data("salary") || "-";
    const description = buttonTarget.data("description");

    $("#detail-main-content .job-title").text(title);
    $("#detail-main-content .company-name").text(companyName);
    $("#detail-main-content .publication-date").text(publicationDate);
    $("#detail-main-content .job-type-value").text(jobType);
    $("#detail-main-content .hiring-from-value").text(hiringFrom);
    $("#detail-main-content .salary-value").text(salary);
    $("#detail-main-content .description-content").html(description);

    $("html").css("overflow-y", "hidden");
    $("#detail-main-content").addClass("active");
  });

  $("#detail-main-content .close-button").on("click", () => {
    $("#detail-main-content").removeClass("active");
    $("html").css("overflow-y", "auto");
  });
});