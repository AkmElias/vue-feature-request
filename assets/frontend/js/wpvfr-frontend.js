(function ($) {
  // login register popup
  $(document).on(
    "click",
    ".tab.btn, .btn.menu, #wpvfr-login-register-popup",
    function () {
      $(".wpvfr-from-msg-status").text("");
      if ($(this).hasClass("tab")) {
        loginRegisterTabHandle(this);
      } else {
        $(".wpvfr-login-register").addClass("show");
        loginRegisterTabHandle(this);
      }
    }
  );

  // close login/register popup
  $(".wpvfr .overlay-close").click(function (e) {
    $(".wpvfr-login-register").removeClass("show");
  });

  // handle login register tab
  function loginRegisterTabHandle(that) {
    if (
      $(that).hasClass("login") ||
      $(that).prop("id") === "wpvfr-login-register-popup"
    ) {
      $("#wpvfr-register-form").removeClass("active-form");
      $(".tab.btn.register").removeClass("active");
      $(".tab.btn.login").addClass("active");
      $("#wpvfr-login-form").addClass("active-form");

      const registerFormInputs = $("#wpvfr-register-form input");
      if (registerFormInputs.next("p").length) {
        registerFormInputs.removeClass("error");
        registerFormInputs.next("p").remove();
      }
    } else {
      $("#wpvfr-login-form").removeClass("active-form");
      $(".tab.btn.login").removeClass("active");
      $(".tab.btn.register").addClass("active");
      $("#wpvfr-register-form").addClass("active-form");
      const loginFromInputs = $("#wpvfr-login-form input");
      if (loginFromInputs.next("p").length) {
        loginFromInputs.removeClass("error");
        loginFromInputs.next("p").remove();
      }
    }
  }

  // handle login/register form
  $(document).on(
    "submit",
    "form#wpvfr-register-form, form#wpvfr-login-form",
    function (e) {
      e.preventDefault();
      if (this.id === "wpvfr-register-form") {
        //get form data in a object
        const data = $(this)
          .serializeArray()
          .reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
          }, {});
        // ajax register request
        $.ajax({
          type: "POST",
          dataType: "json",
          url: ajax_obj.ajaxurl,
          data: {
            action: "wpvfr_user_register",
            nonce: ajax_obj.nonce,
            ...data,
          },
          success(res) {
            if (res.success) {
              $("#wpvfr-register-form").trigger("reset");
              $(`#wpvfr-register-form input`).removeClass("error");
              $(`#wpvfr-register-form input + p`).remove();
              $(".wpvfr-from-msg-status.register").text(
                "Registration successful! Redirecting...."
              );
              setTimeout(() => {
                $("#wpvfr-register-form").removeClass("active-form");
                $(".tab.btn.register").removeClass("active");
                $(".tab.btn.login").addClass("active");
                $("#wpvfr-login-form").addClass("active-form");
              }, 2000);
            }
          },
          error({ responseJSON: { data } }, _, err) {
            const errors = data;
            $(`#wpvfr-register-form input`).removeClass("error");
            $(`#wpvfr-register-form input + p`).remove();
            for (const err in errors) {
              const element = $(`#wpvfr-register-form input[name=${err}]`);
              $(`#wpvfr-register-form input[name=${err}] + p`).remove();
              element.addClass("error");
              element.after(
                `<p style="color: red; font-size: small">${errors[err]}</p>`
              );
            }
          },
        });
      }
      if (this.id === "wpvfr-login-form") {
        //get form data in a object
        const data = $(this)
          .serializeArray()
          .reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
          }, {});

        //ajax login request
        $.ajax({
          type: "POST",
          dataType: "json",
          url: ajax_obj.ajaxurl,
          data: {
            action: "wpvfr_user_login",
            nonce: ajax_obj.nonce,
            ...data,
          },
          success(res) {
            if (res.success) {
              $(".wpvfr-from-msg-status.login").text(
                "Login successful! Redirecting...."
              );
              $("#wpvfr-login-form").trigger("reset");
              $(`#wpvfr-login-form input`).removeClass("error");
              $(`#wpvfr-login-form input + p`).remove();
              setTimeout(() => {
                $(".wpvfr-popup-overlay.wpvfr-login-register").remove();
                location.reload();
              }, 1500);
            }
          },
          error({ responseJSON: { data } }, _, err) {
            const errors = data;
            $(`#wpvfr-login-form input`).removeClass("error");
            $(`#wpvfr-login-form input + p`).remove();
            for (const err in errors) {
              const element = $(`#wpvfr-login-form input[name=${err}]`);
              $(`#wpvfr-login-form input[name=${err}] + p`).remove();
              element.addClass("error");
              element.after(
                `<p style="color: red; font-size: small">${errors[err]}</p>`
              );
            }
          },
        });
      }
    }
  );

  // hover profile log handle
  $(".wpvfr .header-right").hover(
    function () {
      $(".wpvfr .header-right .user-logout-dropdown").show();
    },
    function () {
      $(".wpvfr .header-right .user-logout-dropdown").hide();
    }
  );
  $(".wpvfr .header-right").click(function () {
    $(".wpvfr .header-right .user-logout-dropdown").toggle();
  });

  // handle feature req form show hide
  $(".wpvfr-req-add-button").click(function () {
    $("#wpvfr-req-form-area").animate({
      height: "toggle",
    });
    // $(".frb-req-form-area").toggle();
  });

  // handle feature req form logo
  $(".wpvfr .frb-req-selcet-logo").on("change", function (e) {
    if (window.File && window.FileList && window.FileReader) {
      let file = e.target.files[0];
      if (file) {
        // $(".wpvfr .logowrap .logo-preview-wraper").remove();
        let reader = new FileReader();
        reader.onload = function (e) {
          $(".wpvfr .logowrap .logo-preview-wraper").append(
            '<div class="logo-preview">' +
              '<img class="logo" src="' + 
              e.target.result +
              '" title="' +
              e.target.name +
              '"/>' +
              '<span class="remove-preview-logo">+</span>' +
              "</div>"
          );
          $(".remove-preview-logo").click(function (e) {
            $(this).parent(".logo-preview").remove();
            $(".wpvfr .frb-req-selcet-logo").val("");
          });
        };
        reader.readAsDataURL(file);
      }
    } else {
      alert("Your browser doesn't support to File API");
    }
  });

  // handle feature req form submit
  $(document).on("submit", "form#wpvfr-add-feature-req-form", function (e) {
    e.preventDefault();
    let form_data = new FormData($(this)[0]);
    form_data.append("action", "wpvfr_add_vue_feature_req");
    form_data.append("nonce", ajax_obj.nonce);
    // console.log("submit calleddddddd", form_data);

    $.ajax({
      type: "POST",
      url: ajax_obj.ajaxurl,
      data: form_data,
      enctype: "multipart/form-data",
      processData: false,
      contentType: false,
      success(res) {
        if (res.success) {
          $("#wpvfr-add-feature-req-form").trigger("reset");
          $(".wpvfr .frb-req-selcet-logo").val("");
          $("#wpvfr-add-feature-req-form .logo-preview").remove();
          $(
            `#wpvfr-add-feature-req-form input, #wpvfr-add-feature-req-form textarea`
          ).removeClass("error");
          $(
            `#wpvfr-add-feature-req-form input + p, #wpvfr-add-feature-req-form textarea + p`
          ).remove();
          $(".wpvfr-from-msg-status.feature-req").text(
            "Request add successful....!"
          );
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
      error({ responseJSON: { data } }, _, err) {
        const errors = data;
        $(
          `#wpvfr-add-feature-req-form input, #wpvfr-add-feature-req-form textarea`
        ).removeClass("error");
        $(
          `#wpvfr-add-feature-req-form input + p, #wpvfr-add-feature-req-form textarea + p`
        ).remove();
        for (const err in errors) {
          const element =
            err === "description"
              ? $(`#wpvfr-add-feature-req-form textarea[name=${err}]`)
              : $(`#wpvfr-add-feature-req-form input[name=${err}]`);
          $(
            `#wpvfr-add-feature-req-form input[name=${err}] + p, #wpvfr-add-feature-req-form textarea[name=${err}] + p`
          ).remove();
          element.addClass("error");
          element.after(
            `<p style="color: red; font-size: small;margin-top:-16px; margin-bottom:12px;">${errors[err]}</p>`
          );
        }
      },
    });
  });

  // handle board filter by
  $("#wpvfr-req-select-id").change(function () {
    const sort_by = $(this).val();
    const board_id = $(this).attr("data-id");

    $.ajax({
      type: "POST",
      url: ajax_obj.ajaxurl,
      data: {
        nonce: ajax_obj.nonce,
        action: "wpvfr_update_board_sort_by",
        sort_by,
        board_id,
      },
      success(res) {
        if (res.success) {
          window.location.reload();
        }
      },
      error({ responseJSON: { data } }, _, err) {
        const errors = data;
        alert(errors["board_id"]);
      },
    });
  });

  // handle add vote and remove vote
  $(".wpvfr-request-vote").click(function () {
    const request_id = $(this).attr("data-req-id");
    let add_vote = $(this).hasClass("addVote");
    const that = this;
    $.ajax({
      type: "POST",
      url: ajax_obj.ajaxurl,
      data: {
        nonce: ajax_obj.nonce,
        action: "wpvfr_req_vote_handle",
        request_id,
        add_vote,
      },
      success(res) {
        if (res.success) {
          $(that).toggleClass("removeVote");
          $(that).toggleClass("addVote");
          let input = $(that).children("input");
          if (add_vote) {
            input.val(Number(input.val()) + 1);
          } else {
            input.val(Number(input.val()) - 1);
          }
        }
      },
    });
  });

  // handle comment hide show button
  $(".wpvfr-request-comment-count").click(function () {
    const req_id = $(this).attr("data-req-id");
    $(`.wpvfr-comment-details.${req_id}`).toggle();
  });
})(jQuery);
