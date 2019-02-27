import $ from 'jquery';

// 画像ライブプレビュー
function prevImg() {
  var $dropArea = $('.js-area-drop');
  var $fileInput = $('.js-input-file');

  $dropArea.on('dragover', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '3px #ccc dashed');
  });
  $dropArea.on('dragleave', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', 'none');
  });

  $fileInput.on('change', function (e) {
    $dropArea.css('border', 'none');

    var file = this.files[0], // files配列にファイルが入っている
      $img = $(this).siblings('.js-prev-img'), // jQueryのsiblingsメソッドで兄弟のimgを取得

      fileReader = new FileReader(); // ファイルを読み込むFileReaderオブジェクト
    // 読み込みが完了した際のイベントハンドラ、imgのsrcデータをセット
    fileReader.onload = function (event) {
      // 読み込んだデータをimgに設定
      $img.attr('src', event.target.result).show();
    };

    // 画像読み込み
    fileReader.readAsDataURL(file);
  });
}

export default prevImg;
