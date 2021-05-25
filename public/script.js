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

  const requirements = $(".requirements-list");
  const uppercase = $("#uppercase");
  const number = $("#number");
  const special = $("#special");
  const eightChars = $("#eight-chars");
  const enterPass = $("#enterPass");
  const confirmPass = $("#confirmPass");
  const passSuccess = $(".passSuccess");

  confirmPass.hide();
  passSuccess.hide();

  const checkReq = (...reqArr) => {
    let allTrue = reqArr.every((req) => req.attr("class").includes("fas"));
    if (allTrue) {
      requirements.hide();
      confirmPass.show();
      checkPass();
    } else {
      requirements.show();
      confirmPass.hide();
      passSuccess.hide();
    }
  };

  const checkPass = () => {
    confirmPass.on("input", () => {
      if (enterPass.val() == confirmPass.val()) {
        passSuccess.show();
      } else {
        passSuccess.hide();
      }
    });
  };

  const reqChange = (requirement, bool) => {
    if (bool === true) {
      requirement.addClass("fas").removeClass("far");
      requirement.parent().css("color", "#32936f");
    } else {
      requirement.addClass("far").removeClass("fas");
      requirement.parent().css("color", "#757575");
    }
  };

  enterPass.on("input", () => {
    let passValue = enterPass.val();
    if (passValue.match(/[A-Z]/)) {
      reqChange(uppercase, true);
    } else {
      reqChange(uppercase, false);
    }

    if (passValue.match(/[0-9]/)) {
      reqChange(number, true);
    } else {
      reqChange(number, false);
    }

    if (passValue.match(/[!@#$%^&*.]/)) {
      reqChange(special, true);
    } else {
      reqChange(special, false);
    }

    if (passValue.length > 7) {
      reqChange(eightChars, true);
    } else {
      reqChange(eightChars, false);
    }

    checkReq(uppercase, number, special, eightChars);
  });
});
