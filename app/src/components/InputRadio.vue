<template>
    <div class="form-radio">
      <input
        type="radio"
        v-bind="$attrs"
        :id="uniqueID"
        :class="className"
        :value="value"
        :checked="modelValue === value"
        @change="$emit('update:modelValue', value)"
      />
      <label :for="uniqueID"><slot></slot></label>

    </div>

</template>

<script>
import { v4 as uuidv4 } from 'uuid';

export default {
    props: {
        modelValue: {
            type: [String, Number],
            default: ''
        },
        value: {
            type: [String, Number],
            required: true
        },
        inputID: {
            type: [String, Number],
        },
        className: {
            type: String,
            default: ''
        }
    },
 data: function () {
    return {
      uniqueID: 0
    }
 },
 mounted() {
     if (this.inputID) {
         this.uniqueID = this.inputID;
     } else {
         this.uniqueID = uuidv4();
     }
 }
}

</script>
