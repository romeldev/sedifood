(window.webpackJsonp=window.webpackJsonp||[]).push([[11],{169:function(e,t,r){"use strict";r.r(t);var s=r(1),a=r.n(s);function n(e,t,r,s,a,n,i){try{var o=e[n](i),c=o.value}catch(e){return void r(e)}o.done?t(c):Promise.resolve(c).then(s,a)}function i(e){return function(){var t=this,r=arguments;return new Promise((function(s,a){var i=e.apply(t,r);function o(e){n(i,s,a,o,c,"next",e)}function c(e){n(i,s,a,o,c,"throw",e)}o(void 0)}))}}var o={data:function(){return{icon:"mdi-tag",resource:"setting/supply-types",title:"Tipos de Insumos",titleForm:"Tipo de Insumo",dialog:!1,loading:!1,saving:!1,filter:{search:null},form:new Form({id:null,descrip:null,abrev:null}),headers:[{text:"ID",value:"id"},{text:"Descripcion",value:"descrip"},{text:"Abrev",value:"abrev"},{text:"Accion",value:"action",sortable:!1}],items:[],meta:{printers:[],series:[]}}},computed:{},mounted:function(){this.getMeta(),this.getItems()},methods:{openForm:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.form.clear(),this.form.reset(),null!==e&&this.form.fill(JSON.parse(JSON.stringify(e))),this.dialog=!0},closeForm:function(){this.dialog=!1},getMeta:function(){var e=this;return i(a.a.mark((function t(){var r,s,n;return a.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,r={service:"get-meta-crud-boxes"},t.next=4,e.form.get("/common",{params:r});case 4:s=t.sent,n=s.data,e.meta=n,t.next=12;break;case 9:t.prev=9,t.t0=t.catch(0),e.$toast(params.service,"danger");case 12:case"end":return t.stop()}}),t,null,[[0,9]])})))()},getItems:function(){var e=this;return i(a.a.mark((function t(){var r,s;return a.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,e.loading=!0,t.next=4,e.form.get("/".concat(e.resource));case 4:r=t.sent,s=r.data,e.items=s,t.next=12;break;case 9:t.prev=9,t.t0=t.catch(0),e.$toast(t.t0.message,"danger");case 12:return t.prev=12,e.loading=!1,t.finish(12);case 15:case"end":return t.stop()}}),t,null,[[0,9,12,15]])})))()},submit:function(){var e=arguments,t=this;return i(a.a.mark((function r(){var s,n,i,o;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(s=e.length>0&&void 0!==e[0]?e[0]:"create",r.prev=1,t.form.clear(),t.saving=!0,n=t.items.findIndex((function(e){return e.id===t.form.id})),"delete"!==s||confirm("¿Realmente desea eliminar el registro?")){r.next=8;break}return t.dialog=!1,r.abrupt("return");case 8:return r.next=10,t.form.req("/".concat(t.resource),s);case 10:i=r.sent,o=i.data,"create"===s&&(t.items.unshift(o),t.$toast("registro creado!","success")),"edit"===s&&(t.items.splice(n,1,o),t.$toast("registro actualizado!","success")),"delete"===s&&(t.items.splice(n,1),t.$toast("registro eliminado!","success")),t.dialog=!1,r.next=21;break;case 18:r.prev=18,r.t0=r.catch(1),t.$toast(r.t0.message,"danger");case 21:return r.prev=21,t.saving=!1,r.finish(21);case 24:case"end":return r.stop()}}),r,null,[[1,18,21,24]])})))()}}},c=r(2),l=Object(c.a)(o,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("v-dialog",{attrs:{scrollable:"",persistent:"","max-width":"500px"},model:{value:e.dialog,callback:function(t){e.dialog=t},expression:"dialog"}},[r("v-card",[r("v-card-title",[r("span",{staticClass:"headline"},[r("v-icon",{attrs:{left:""}},[e._v(e._s(e.icon))]),e._v("\n                    "+e._s(e.titleForm)+"\n                ")],1)]),e._v(" "),r("v-divider"),e._v(" "),r("v-card-text",{staticClass:"pt-5"},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"12"}},[r("v-text-field",{attrs:{outlined:"",dense:"",label:"Descripcion*","hide-details":"auto",error:e.form.errors.has("descrip"),"error-messages":e.form.errors.get("descrip")},model:{value:e.form.descrip,callback:function(t){e.$set(e.form,"descrip",t)},expression:"form.descrip"}})],1),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"12"}},[r("v-text-field",{attrs:{outlined:"",dense:"",label:"Abrev*","hide-details":"auto",error:e.form.errors.has("abrev"),"error-messages":e.form.errors.get("abrev")},model:{value:e.form.abrev,callback:function(t){e.$set(e.form,"abrev",t)},expression:"form.abrev"}})],1)],1),e._v(" "),r("small",[e._v("*Campos requeridos")])],1),e._v(" "),r("v-divider"),e._v(" "),r("v-card-actions",[r("v-spacer"),e._v(" "),r("v-btn",{attrs:{text:"",disabled:e.saving},on:{click:e.closeForm}},[e._v("close")]),e._v(" "),e.form.id?e._e():r("v-btn",{attrs:{text:"",color:"primary",disabled:e.saving},on:{click:function(t){return e.submit("create")}}},[e._v("Crear")]),e._v(" "),e.form.id?r("v-btn",{attrs:{text:"",color:"error",disabled:e.saving},on:{click:function(t){return e.submit("delete")}}},[e._v("Eliminar")]):e._e(),e._v(" "),e.form.id?r("v-btn",{attrs:{text:"",color:"success",disabled:e.saving},on:{click:function(t){return e.submit("edit")}}},[e._v("Editar")]):e._e()],1)],1)],1),e._v(" "),r("v-card",[r("v-card-title",[r("v-icon",{attrs:{left:""}},[e._v(e._s(e.icon))]),e._v("\n            "+e._s(e.title)+"\n            "),r("v-btn",{staticClass:"ml-3",attrs:{"x-small":"",fab:"",elevation:"1",color:"primary"},on:{click:function(t){return e.openForm()}}},[r("v-icon",[e._v("mdi-plus")])],1),e._v(" "),r("v-spacer"),e._v(" "),r("v-text-field",{attrs:{dense:"",type:"search","append-icon":"mdi-magnify",label:"Buscar","single-line":"","hide-details":""},model:{value:e.filter.search,callback:function(t){e.$set(e.filter,"search",t)},expression:"filter.search"}})],1),e._v(" "),r("v-data-table",{attrs:{headers:e.headers,items:e.items,loading:e.loading,search:e.filter.search},scopedSlots:e._u([{key:"item.roles",fn:function(t){var r=t.item;return[e._v("\n                "+e._s(r.roles.map((function(e){return e.name})).toString())+"\n            ")]}},{key:"item.action",fn:function(t){var s=t.item;return[r("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return e.openForm(s)}}},[e._v("\n                    mdi-pencil\n                ")])]}}],null,!0)})],1)],1)}),[],!1,null,null,null);t.default=l.exports}}]);
//# sourceMappingURL=11.js.map