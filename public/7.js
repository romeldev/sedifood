(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{171:function(e,t,r){"use strict";r.r(t);var n=r(1),a=r.n(n);function s(e,t,r,n,a,s,i){try{var o=e[s](i),c=o.value}catch(e){return void r(e)}o.done?t(c):Promise.resolve(c).then(n,a)}function i(e){return function(){var t=this,r=arguments;return new Promise((function(n,a){var i=e.apply(t,r);function o(e){s(i,n,a,o,c,"next",e)}function c(e){s(i,n,a,o,c,"throw",e)}o(void 0)}))}}var o={data:function(){return{icon:"mdi-tag",resource:"setting/food-types",title:"Tipos de Comidas",titleForm:"Tipo de Comida",dialog:!1,loading:!1,saving:!1,filter:{search:null},form:new Form({id:null,descrip:null,abrev:null}),headers:[{text:"ID",value:"id"},{text:"Descripcion",value:"descrip"},{text:"Accion",value:"action",sortable:!1}],items:[],meta:{printers:[],series:[]}}},computed:{},mounted:function(){this.getItems()},methods:{openForm:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.form.clear(),this.form.reset(),null!==e&&this.form.fill(JSON.parse(JSON.stringify(e))),this.dialog=!0},closeForm:function(){this.dialog=!1},getMeta:function(){var e=this;return i(a.a.mark((function t(){var r,n,s;return a.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,r={service:"get-meta-crud-boxes"},t.next=4,e.form.get("/common",{params:r});case 4:n=t.sent,s=n.data,e.meta=s,t.next=12;break;case 9:t.prev=9,t.t0=t.catch(0),e.$toast(params.service,"danger");case 12:case"end":return t.stop()}}),t,null,[[0,9]])})))()},getItems:function(){var e=this;return i(a.a.mark((function t(){var r,n;return a.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,e.loading=!0,t.next=4,e.form.get("/".concat(e.resource));case 4:r=t.sent,n=r.data,e.items=n,t.next=12;break;case 9:t.prev=9,t.t0=t.catch(0),e.$toast(t.t0.message,"danger");case 12:return t.prev=12,e.loading=!1,t.finish(12);case 15:case"end":return t.stop()}}),t,null,[[0,9,12,15]])})))()},submit:function(){var e=arguments,t=this;return i(a.a.mark((function r(){var n,s,i,o;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(n=e.length>0&&void 0!==e[0]?e[0]:"create",r.prev=1,t.form.clear(),t.saving=!0,s=t.items.findIndex((function(e){return e.id===t.form.id})),"delete"!==n||confirm("¿Realmente desea eliminar el registro?")){r.next=8;break}return t.dialog=!1,r.abrupt("return");case 8:return r.next=10,t.form.req("/".concat(t.resource),n);case 10:i=r.sent,o=i.data,"create"===n&&(t.items.unshift(o),t.$toast("registro creado!","success")),"edit"===n&&(t.items.splice(s,1,o),t.$toast("registro actualizado!","success")),"delete"===n&&(t.items.splice(s,1),t.$toast("registro eliminado!","success")),t.dialog=!1,r.next=21;break;case 18:r.prev=18,r.t0=r.catch(1),t.$toast(r.t0.message,"danger");case 21:return r.prev=21,t.saving=!1,r.finish(21);case 24:case"end":return r.stop()}}),r,null,[[1,18,21,24]])})))()}}},c=r(2),l=Object(c.a)(o,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("v-dialog",{attrs:{scrollable:"",persistent:"","max-width":"500px"},model:{value:e.dialog,callback:function(t){e.dialog=t},expression:"dialog"}},[r("v-card",[r("v-card-title",[r("span",{staticClass:"headline"},[r("v-icon",{attrs:{left:""}},[e._v(e._s(e.icon))]),e._v("\n                    "+e._s(e.titleForm)+"\n                ")],1)]),e._v(" "),r("v-divider"),e._v(" "),r("v-card-text",{staticClass:"pt-5"},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"12"}},[r("v-text-field",{attrs:{outlined:"",dense:"",label:"Descripcion*","hide-details":"auto",error:e.form.errors.has("descrip"),"error-messages":e.form.errors.get("descrip")},model:{value:e.form.descrip,callback:function(t){e.$set(e.form,"descrip",t)},expression:"form.descrip"}})],1)],1),e._v(" "),r("small",[e._v("*Campos requeridos")])],1),e._v(" "),r("v-divider"),e._v(" "),r("v-card-actions",[r("v-spacer"),e._v(" "),r("v-btn",{attrs:{text:"",disabled:e.saving},on:{click:e.closeForm}},[e._v("close")]),e._v(" "),e.form.id?e._e():r("v-btn",{attrs:{text:"",color:"primary",disabled:e.saving},on:{click:function(t){return e.submit("create")}}},[e._v("Crear")]),e._v(" "),e.form.id?r("v-btn",{attrs:{text:"",color:"error",disabled:e.saving},on:{click:function(t){return e.submit("delete")}}},[e._v("Eliminar")]):e._e(),e._v(" "),e.form.id?r("v-btn",{attrs:{text:"",color:"success",disabled:e.saving},on:{click:function(t){return e.submit("edit")}}},[e._v("Editar")]):e._e()],1)],1)],1),e._v(" "),r("v-card",[r("v-card-title",[r("v-icon",{attrs:{left:""}},[e._v(e._s(e.icon))]),e._v("\n            "+e._s(e.title)+"\n            "),r("v-btn",{staticClass:"ml-3",attrs:{"x-small":"",fab:"",elevation:"1",color:"primary"},on:{click:function(t){return e.openForm()}}},[r("v-icon",[e._v("mdi-plus")])],1),e._v(" "),r("v-spacer"),e._v(" "),r("v-text-field",{attrs:{dense:"",type:"search","append-icon":"mdi-magnify",label:"Buscar","single-line":"","hide-details":""},model:{value:e.filter.search,callback:function(t){e.$set(e.filter,"search",t)},expression:"filter.search"}})],1),e._v(" "),r("v-data-table",{attrs:{headers:e.headers,items:e.items,loading:e.loading,search:e.filter.search},scopedSlots:e._u([{key:"item.roles",fn:function(t){var r=t.item;return[e._v("\n                "+e._s(r.roles.map((function(e){return e.name})).toString())+"\n            ")]}},{key:"item.action",fn:function(t){var n=t.item;return[r("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return e.openForm(n)}}},[e._v("\n                    mdi-pencil\n                ")])]}}],null,!0)})],1)],1)}),[],!1,null,null,null);t.default=l.exports}}]);
//# sourceMappingURL=7.js.map