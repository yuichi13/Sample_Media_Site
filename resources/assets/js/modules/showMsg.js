import $ from 'jquery';

function showMsg() {
  // メッセージ表示
  let $jsShowMsg = $('.js-show-msg');
  let msg = $jsShowMsg.text();

  if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
    $jsShowMsg.slideToggle('slow');
    setTimeout(function () {
      $jsShowMsg.slideToggle('slow');
    }, 5000);
  }
};

export default showMsg;
