$(() => {
  $("form").on("click", ".toggle-password", () => {
    $(".toggle-password").toggleClass("fa-eye fa-eye-slash");
    let input = $(".password");
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
});
