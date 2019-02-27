<aside class="c-sidebar">
      <div class="c-side-prof">
        <div class="c-side-prof__header">
          <img src="{{ $dbUserData->avatar() }}" alt="" class="c-side-prof__img">
        </div>
        <div class="c-side-prof__body">
          <h3 class="c-side-prof__name">{{ $dbUserData->userName() }}</h3>
          <p class="c-side-prof__text">{{ $dbUserData->profile }}</p>
        </div>
      </div>
</aside>