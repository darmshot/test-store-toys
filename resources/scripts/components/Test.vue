<template>
<div class="test">
  <div class="container">
    <div class="row">
      <div class="col-sm-5 py-3 bg-warning">
      </div>
      <div class="col-sm-7 py-3 bg-success"></div>
    </div>
    <TestButton/>
  </div>
  <div class="custom-container">

    <div class="example-container">
      <div class="example-row">
        <div class="example-content-main">Main content</div>
        <div class="example-content-secondary">Secondary content</div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import TestButton from "./TestButton"

export default {
  components: {
    TestModal,
    TestButton
  }
}
</script>

<style scoped lang="scss">
@import './assets/sass/bootstrap';

.custom-container {
  $grid-gutter-width:10px;
  .example-container {
    max-width: 800px;
    @include make-container();
  }

  .example-row {
    @include make-row();
  }

  .example-content-main {
    @include make-col-ready();

    @include media-breakpoint-up(sm) {
      @include make-col(6);
    }
    @include media-breakpoint-up(lg) {
      @include make-col(8);
    }
  }

  .example-content-secondary {
    @include make-col-ready();

    @include media-breakpoint-up(sm) {
      @include make-col(6);
    }
    @include media-breakpoint-up(lg) {
      @include make-col(4);
    }
  }
}
.test {
  padding: 30px 0;
}
</style>
