(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-1c971ec4"],{"466d":function(e,t,a){"use strict";var r=a("c65b"),n=a("d784"),l=a("825a"),s=a("50c4"),i=a("577e"),o=a("1d80"),u=a("dc4a"),c=a("8aa5"),d=a("14c3");n("match",(function(e,t,a){return[function(t){var a=o(this),n=void 0==t?void 0:u(t,e);return n?r(n,t,a):new RegExp(t)[e](i(a))},function(e){var r=l(this),n=i(e),o=a(t,r,n);if(o.done)return o.value;if(!r.global)return d(r,n);var u=r.unicode;r.lastIndex=0;var p,m=[],f=0;while(null!==(p=d(r,n))){var h=i(p[0]);m[f]=h,""===h&&(r.lastIndex=c(n,s(r.lastIndex),u)),f++}return 0===f?null:m}]}))},"5b81":function(e,t,a){"use strict";var r=a("23e7"),n=a("da84"),l=a("c65b"),s=a("e330"),i=a("1d80"),o=a("1626"),u=a("44e7"),c=a("577e"),d=a("dc4a"),p=a("90d8"),m=a("0cb2"),f=a("b622"),h=a("c430"),v=f("replace"),g=n.TypeError,x=s("".indexOf),y=s("".replace),b=s("".slice),w=Math.max,$=function(e,t,a){return a>e.length?-1:""===t?a:x(e,t,a)};r({target:"String",proto:!0},{replaceAll:function(e,t){var a,r,n,s,f,_,A,k,C,E=i(this),S=0,q=0,z="";if(null!=e){if(a=u(e),a&&(r=c(i(p(e))),!~x(r,"g")))throw g("`.replaceAll` does not allow non-global regexes");if(n=d(e,v),n)return l(n,e,E,t);if(h&&a)return y(c(E),e,t)}s=c(E),f=c(e),_=o(t),_||(t=c(t)),A=f.length,k=w(1,A),S=$(s,f,0);while(-1!==S)C=_?c(t(f,S,s)):m(f,s,S,[],void 0,t),z+=b(s,q,S)+C,q=S+A,S=$(s,f,S+k);return q<s.length&&(z+=b(s,q)),z}})},"90d8":function(e,t,a){var r=a("c65b"),n=a("1a2d"),l=a("3a9b"),s=a("ad6d"),i=RegExp.prototype;e.exports=function(e){var t=e.flags;return void 0!==t||"flags"in i||n(e,"flags")||!l(i,e)?t:r(s,e)}},bc8c:function(e,t,a){"use strict";a.r(t);var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"mb-2"},[a("div",{staticClass:"font-bold"},[e._v(e._s(e.question))]),a("input",{ref:e.name,staticClass:"bg-white border focus:outline-none p-3 w-full",class:{"border-red-300 placeholder-red-300":e.v&&e.v.$error},attrs:{placeholder:e.placeholder,name:e.name,type:e.type,required:e.required,readonly:e.readonly,min:"0",max:e.max,maxlength:e.max,size:e.max,pattern:"phoneNumber"==e.name?"\\d*":""},domProps:{value:e.value},on:{input:e.formatValidateAndInput,keydown:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"delete",[8,46],t.key,["Backspace","Delete","Del"])?null:e.$emit("backspace")}}}),e.errorMessage?[a("span",{staticClass:"text-red-500 text-xs ml-1"},[e._v(e._s(e.errorMessage))])]:e._e(),e.v?[e.v.$anyError&&0==e.v.required?a("span",{staticClass:"text-red-500 text-xs ml-1"},[e._v("Field is required")]):e._e(),e.v.$anyError&&0==e.v.email?a("span",{staticClass:"text-red-500 text-xs ml-1"},[e._v("Email is not valid")]):e.v.$anyError&&0==e.v.minLength?a("span",{staticClass:"text-red-500 text-xs ml-1"},[e._v("Field value is not in minimum allowed range")]):e.v.$anyError&&0==e.v.maxLength?a("span",{staticClass:"text-red-500 text-xs ml-1"},[e._v("Field value is beyond maximum allowed range")]):a("span")]:e._e()],2)},n=[],l=(a("b0c0"),a("ac1f"),a("466d"),a("5319"),a("5b81"),{components:{},props:{type:{type:String,default:""},label:{type:String,default:""},name:{type:String,default:""},placeholder:{type:String,default:""},readonly:{type:String,default:null},required:{type:Boolean,default:!0},v:{type:Object,default:null},question:{type:String,default:null},value:{type:String,default:""}},methods:{formatValidateAndInput:function(e){var t=e.target.value;if(console.log(this.name),"phoneNumber"==this.name){var a=t.replace(/\D/g,"").match(/(\d{0,3})(\d{0,3})(\d{0,4})/);null!=t.match(/[a-zA-Z]\D+/)?this.errorMessage="Alphabets Or Special Characters are not allowed":this.errorMessage=null,t=a[2]?"("+a[1]+") "+a[2]+(a[3]?"-"+a[3]:""):a[1]}else if("height"==this.name){t=t.replaceAll("'","");var r=t.replace(/\D/g,"").match(/(\d{0,1})(\d{0,2})/);t.length>1&&(parseInt(r[1],10)>9&&(r[2]="9"),parseInt(r[2],10)>12&&(r[2]="12"),t=r[1]+"'"+r[2]+"''")}else if("firstName"==this.name){var n=t.match(/[a-zA-Z]+/);null==n?(this.$refs.firstName.value=n,t=n):t=n}else if("lastName"==this.name){var l=t.match(/[a-zA-Z]+/);null==l?(this.$refs.lastName.value=l,t=l):t=l}else if("state"==this.name){var s=t.match(/[a-zA-Z]+/);console.log(s),null==s?(this.$refs.state.value=s,t=s):t=s}else if("city"==this.name){var i=t.match(/^[a-zA-Z ]*$/);console.log(i),null==i?(this.$refs.city.value=i,t=i):t=i}else if("country"==this.name){var o=t.match(/[a-zA-Z]+/);console.log(o),null==o?(this.$refs.country.value=o,t=o):t=o}this.$emit("input",t)}},computed:{max:function(){switch(this.name){case"height":return 6;case"phoneNumber":return 14;default:return null}}},data:function(){return{errorMessage:null}}}),s=l,i=a("2877"),o=Object(i["a"])(s,r,n,!1,null,null,null);t["default"]=o.exports}}]);
//# sourceMappingURL=chunk-1c971ec4.js.map