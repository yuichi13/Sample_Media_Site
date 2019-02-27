import $ from 'jquery';

function confirm() {


  $('.js-btn-del').on('click', function (e) {

    if (window.confirm($('.js-btn-del').data('message'))) {
      location.href = 'user/post-delete/'.data;
    } else {
      return false;
    }
  });
}

export default confirm;
