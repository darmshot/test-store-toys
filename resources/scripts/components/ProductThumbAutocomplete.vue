<template>
  <div class="product-thumb-autocomplete" >
<!--    <div v-if="product.thumb && ['xs','md','lg','xl','xxl'].includes($screen.breakpoint)" class="product-thumb-autocomplete__thumb">-->
<!--      <img v-lazy="{src:product.thumb}"-->
<!--           :alt="product.title"-->
<!--           class="product-thumb-autocomplete__image">-->
<!--    </div>-->
    <div class="product-thumb-autocomplete__text">
      <div class="product-thumb-autocomplete__title">
          {{product.href}}
        <a :href="product.url">
          {{ product.title }}
        </a>
      </div>
      <div class="product-thumb-autocomplete__caption">{{ product.sku }}</div>
    </div>
<!--    <div v-if="['xs','md','lg','xl','xxl'].includes($screen.breakpoint)" class="product-thumb-autocomplete__price">-->
<!--      <template v-if="product.special">-->
<!--        <span class="product-thumb-autocomplete__price-old" v-html="product.price">-->
<!--        </span>-->
<!--        &nbsp;-->
<!--        <span class="product-thumb-autocomplete__price-main" v-html="product.special"></span>-->
<!--      </template>-->
<!--      <template v-else>-->
<!--        <span class="product-thumb-autocomplete__price-main" v-html="product.price">-->
<!--      </span>-->
<!--      </template>-->
<!--    </div>-->
  </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        product: Object,
    },
})
</script>

<style lang="scss">
@import "resources/sass/bootstrap";

.product-thumb-autocomplete {
  $root: &;
  display: flex;
  margin-right: -6px;
  margin-left: -6px;

  &--dark {
    #{$root}__title {
      a {
        color: $white;
        transition: .3s;

        &:hover {
          color: $white;
        }
      }
    }
    #{$root}__image{
      border-color: black;
    }


   #{$root}__price-main {
      color: $white;
      font-weight: 600;
    }
  }

  &:hover {
    #{$root}__title {
      a {
        text-decoration: underline;
      }
    }
  }

  > div {
    padding-right: 6px;
    padding-left: 6px;
  }

  &__thumb {
    flex: 0 0 90px;
  }


  &__image {
    width: 100%;
    height: auto;
    border: 3px solid $gray-200;
    border-radius: 2px;
  }

  &__title {
    line-height: 1.2;
    a {
      color: $body-color;
      transition: .3s;
      white-space: normal;
      line-height: 1.2;
      &:hover {
        color: $gray-600;
      }
    }
  }

  &__text {
    flex: 1 0 0;
  }

  &__caption {
    color: $gray-300;
  }

  &__price-main {
    color: $gray-600;
    font-weight: 600;
  }

  &__price-old {
    text-decoration: line-through;
  }
}
</style>
