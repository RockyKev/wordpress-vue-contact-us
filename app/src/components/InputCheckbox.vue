<template>
    <div class="form-checkbox">
        <input
        :id="uniqueID"
        type="checkbox"
        :checked="modelValue"
        @change="$emit('update:modelValue', $event.target.checked)"
        :class="className"
        />
        <label :for="uniqueID"><slot></slot><span v-if="required" class="red">*</span></label>
    </div>

</template>

<script>
import { v4 as uuidv4 } from 'uuid';

export default {
    props: {
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
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
