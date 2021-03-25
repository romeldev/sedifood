import Vue from 'vue'

Vue.filter('textcut', function(value, size) {

  if(!value) return ''

  if( value.length > size) return value.substring(0, size-3)+'...'

  return value
})
