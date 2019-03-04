import $ from 'jquery';

export default function count() {

  var $countVal = $('.js-count-val');
  var $countShow = $('.js-count-show');
  var $countLimit = $('.js-count-limit');
  var $countNum = $('.js-count-num');

  if ($countVal.val()) {
    $countShow.html(($countVal.val().length) ? $countVal.val().length : 0);
  }

  $($countVal).on('keyup', function () {
    var val = $(this).val().length;
    $($countShow).html(val);

    if(val > Number($countLimit.html())){
      $countNum.addClass('hasError');
    } else{
      $countNum.removeClass('hasError');
    }
  });
};
