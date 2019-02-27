import $ from 'jquery';

export default function count() {
  var $countVal = $('.js-count-val');
  var $countShow = $('.js-count-show');
  if ($countVal.val()) {
    $countShow.html(($countVal.val().length) ? $countVal.val().length : 0);
  }
  $($countVal).on('keyup', function () {
    var val = $(this).val().length;
    $($countShow).html(val);
  });
};
