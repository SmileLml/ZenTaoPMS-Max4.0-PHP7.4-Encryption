var p=Object.defineProperty,d=Object.defineProperties;var l=Object.getOwnPropertyDescriptors;var r=Object.getOwnPropertySymbols;var m=Object.prototype.hasOwnProperty,g=Object.prototype.propertyIsEnumerable;var e=(o,t,i)=>t in o?p(o,t,{enumerable:!0,configurable:!0,writable:!0,value:i}):o[t]=i,n=(o,t)=>{for(var i in t||(t={}))m.call(t,i)&&e(o,i,t[i]);if(r)for(var i of r(t))g.call(t,i)&&e(o,i,t[i]);return o},f=(o,t)=>d(o,l(t));import{H as a}from"./index-24dedbe0.js";import{d as h}from"./chartEditStore-8254eca3.js";import{as as s,aA as c}from"./index-67a30bc6.js";import"./_arrayMap-23a2d4b9.js";import"./tables_list-7cb7cb60.js";import"./http-630f50b2.js";import"./plugin-463a9df8.js";import"./icon-99a136c4.js";import"./SettingItemBox-a2ea547e.js";/* empty css                                                                   */import"./CollapseItem-92fb7302.js";const u={text:"",icon:"",textSize:30,textColor:"#ffffff",textWeight:"bold",placement:"left-top",distance:8,hint:"\u8FD9\u662F\u63D0\u793A\u6587\u672C",width:0,height:0,paddingX:16,paddingY:8,borderWidth:1,borderStyle:"solid",borderColor:"#1a77a5",borderRadius:6,color:"#ffffff",textAlign:"left",fontWeight:"normal",backgroundColor:"rgba(89, 196, 230, .2)",fontSize:24};class H extends h{constructor(){super(...arguments),this.key=a.key,this.chartConfig=s(a),this.option=s(u),this.attr=f(n({},c),{w:36,h:36,zIndex:1})}}export{H as default,u as option};
