function  Draws (id,setting,callback){
    this.canvas=document.getElementById(id);
    this.container = this.canvas.parentNode;   
    this.speed=setting.speed || 2000;       
    this.lineW=setting.lineW || 10;
    this.lineColor=setting.lineColor ||"#fbab16";
    this.bgColor=setting.bgColor || "#fbab16" ;
    this.containerW=this.container.offsetWidth;
    this.containerH=this.container.offsetHeight;
    this.radius=(this.containerW-this.lineW)/2;    
    this.initNum=0;
    this.maxNum=2;
    this.s= (this.maxNum/this.speed)*30;
    this.runing(callback);
  }

  Draws.prototype.runing=function(callback){
    var _this=this
    var set=setInterval(function(){
      if(_this.initNum>=_this.maxNum){
        clearInterval(set);
        callback();
      }else{
        _this.initNum+=_this.s
        _this.drawInit()
      }
    },30)
  }

  Draws.prototype.drawInit=function(){
    this.canvas.width=this.containerW;
    this.canvas.height=this.containerH;
    var ctx=this.canvas.getContext("2d")
    ctx.clearRect(0,0,this.containerW,this.containerH)
    ctx.beginPath();
//  ctx.lineCap="round";
    ctx.arc(this.containerW/2, this.containerH/2, this.radius, 0, 2*Math.PI, false);
    ctx.lineWidth = this.lineW;
    ctx.strokeStyle = this.bgColor;
    ctx.stroke();
    ctx.closePath();
    ctx.beginPath();
    ctx.arc(this.containerW/2, this.containerH/2, this.radius, 0, this.initNum*Math.PI, false);  
    ctx.lineWidth = this.lineW;
    ctx.strokeStyle = this.lineColor;
    ctx.stroke();
    ctx.closePath();
  }