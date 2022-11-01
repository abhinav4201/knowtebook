/*hide headnavbar*/
var prevScrollpos= window.pageYOffset;
window.onscroll = function(){
    var currentScrollpos= window.pageYOffset;
    if(prevScrollpos > currentScrollpos){
        document.getElementById("header").style.top = "0";
        document.getElementById("foot").style.bottom = "0";
    }else {
        document.getElementById("header").style.top = "-50px";
        document.getElementById("foot").style.bottom = "-50px";
    }
    prevScrollpos=currentScrollpos;
}
/*refresh captcha*/
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
/*showpassword*/
  function showPassword()
  {
      var x= document.getElementById("pass");
      if(x.type === "password")
      {
          x.type = "text";
      }else{
          x.type="password";
      }
  }
/*notification*/
function Notification() {
    $.ajax({
        url: "view_notification.php",
        type: "POST",
        processData:false,
        success: function(data){
            $("#notification-count").remove();					
            $("#notification-latest").html(data);
        },
        error: function(){}           
    });
    var x= document.getElementById("notifi");
    if (x.className === "notifi1"){
        x.className += " notifi2";
    }
    else{
        x.className ="notifi1";
    }
 }
/*clearform*/
function clearform()
{
    $('.C05').reset()
}
/*checkUser*/
  function checkUser(user)
    {
        {
            if (user.value == '')
            {
                $('#used').html('&nbsp;')
                return
            }
            $.post
                ('checkuser.php',
                { user : user.value },
                function(data)
                {
                    $('#used').html(data)
                }
                )
        }
    }
/*checkAd*/
function checkAd(ads)
{
    {
        $.post
            ('checkad.php',
                { ads : ads.value },
                function(data)
                {
                    $('#ads03').html(data)
                }
            )
    }
}
/*checkPass*/
function checkPass(pass)
    {
        {
            if (pass.value == '')
            {
                $('#used2').html('&nbsp;')
                return
            }
            else if (pass.value.length < 6)
            {
                $('#used2').html('<span class="error">Password must be at least 6 characters</span>')
                return
            }
            else if (!/[a-z]/.test(pass.value) || ! /[A-Z]/.test(pass.value) ||
                    !/[0-9]/.test(pass.value))
            {
                $('#used2').html('<span class="error">Password require one each of a-z, A-Z and 0-9</span>')
                return
            }
            else
            {
                $('#used2').html('&nbsp;')
                return
            }
        }
    }
/*CheckEmail */
function checkEmail(email)
    {
        if(email.value=="")
        {
            $('#used3').html('<span>Keep id safe for Clean slate update</span>')
            return
        }
        else if (!((email.value.indexOf(".") > 3) &&
            (email.value.indexOf("@") > 0)) ||
            /[^a-zA-Z0-9.@_-]/.test(email.value))
            {
                $('#used3').html('<span class="error">The Email address is invalid.</span>')
                return
            }
        else
        {
            $('#used3').html('<span class="available">Keep id safe for Clean slate update</span>')
            return
        }
    }
/*findEmail*/
function findEmail(email)
{
    if (email.value == '')
    {
        $('#used4').html('&nbsp;')
        return
    }
    $.post
        ('findemail.php',
            { email : email.value },
            function(data)
            {
                $('#used4').html(data)
            }
        )
}
/*findUser*/
function findUser(user)
{
    if (user.value == '')
    {
        $('#used').html('&nbsp;')
        return
    }
    $.post
        ('finduser.php',
            { user : user.value },
            function(data)
            {
                $('#used').html(data)
            }
        )
}
/*compare Password*/
function comparePassword()
{
    var x = document.getElementById("pass107");
    var y = document.getElementById("pass207");
    if (x.value != y.value)
    {
        pass207.setCustomValidity("Password do not match");
    }else{
        pass207.setCustomValidity("");
    }
}
/*openNav + closeNav*/
function openNav(){
    document.getElementById('myNav').style.width='100%';
}
function closeNav(){
    document.getElementById('myNav').style.width='0';
}
/*change Category*/
function changeCat(category)
{
    if (category.value == '')
    {
        $('#used').html('&nbsp;')
        return
    }
    $.post
        ('changecat.php',
            { category : category.value },
            function(data)
            {
                $('#cnt500').html(data)
            }
        )
}
/*responsive navbar*/
function responseNav() {
    var x= document.getElementById("navbar");
    if (x.className === "topnav"){
        x.className += " responsive";
    }
    else{
        x.className ="topnav";
    }
}
/*changeAd*/
function changeAd(ads)
{
    {
        $.post
            ('changead.php',
                { ads : ads.value },
                function(data)
                {
                    $('#ads03').html(data)
                }
            )
    }
}
/*address*/
function Address(address)
{
    $('#nb100').html(address.value)
    
}
function cAdd()
{
    $('#nb100').html('&nbsp;')
    return
}
/*sponsor*/
function sponsor(sponsor)
{
    {
        $.post
            ('sponsor.php',
                { sponsor : sponsor.value },
                function(data)
                {
                    $('#bt100').html(data)
                }
            )
        var x= document.getElementById('tc90').innerText;
        var y= parseInt(x)+1;
        $('#tc90').html(y)
    }
}
function unfollow(unfollow)
{
    {
        $.post
            ('sponsor.php',
                { unfollow : unfollow.value },
                function(data)
                {
                    $('#bt100').html(data)
                }
            )
            var a= document.getElementById('tc90').innerText;
            var b= parseInt(a)-1;
            $('#tc90').html(b)
    }
}
/*inserting like dislike and count*/
function likeR(likeR)
{
    {
        $.post
            ('rcount.php',
                { likeR : likeR.value },
                function(data)
                {
                    $('#lik500').html(data)
                }
            )
    }
}
function unlikeR(unlikeR)
{
    {
        $.post
            ('rcount.php',
                { unlikeR : unlikeR.value },
                function(data)
                {
                    $('#lik500').html(data)
                }
            )
    }
}
function dlikeR(dlikeR)
{
    {
        $.post
            ('rcount.php',
                { dlikeR : dlikeR.value },
                function(data)
                {
                    $('#lik501').html(data)
                }
            )
    }
}
function likeP(likeP)
{
    {
        $.post
            ('rcount.php',
                { likeP : likeP.value },
                function(data)
                {
                    $('#lik500').html(data)
                }
            )
    }
}
function unlikeP(unlikeP)
{
    {
        $.post
            ('rcount.php',
                { unlikeP : unlikeP.value },
                function(data)
                {
                    $('#lik500').html(data)
                }
            )
    }
}
function dlikeP(dlikeP)
{
    {
        $.post
            ('rcount.php',
                { dlikeP : dlikeP.value },
                function(data)
                {
                    $('#lik501').html(data)
                }
            )
    }
}
/*achievement edu and work*/
function achievemente()
{
    $('#ach302').html('<span class="available"><p>Separate each achievement with comma<br> Phd <span style="font-size:22px;">&rarr;</span>SSC</p></span>')
    return
}
function achievementw()
{
    $('#ach305').html('<span class="available"><p>Separate each achievement with comma<br>Current <span style="font-size:22px;">&rarr;</span>Previous</p></span>')
    return
}
/*toggle total sponsor*/
function Ysp(){
    document.getElementById("tc100").style.display = "none";
    document.getElementById("tsp100").style.display = "table";
}
function closeYsp(){
    document.getElementById("tc100").style.display = "table";
    document.getElementById("tsp100").style.display = "none";
}
/*toggle your reported*/
function Yr(){
    document.getElementById("tc100").style.display = "none";
    document.getElementById("yr100").style.display = "table";
}
function closeYr(){
    document.getElementById("tc100").style.display = "table";
    document.getElementById("yr100").style.display = "none";
}
/*toggle your reported count*/
function Yrc(){
    document.getElementById("tc100").style.display = "none";
    document.getElementById("yrc100").style.display = "table";
}
function closeYrc(){
    document.getElementById("tc100").style.display = "table";
    document.getElementById("yrc100").style.display = "none";
}
/*toggle select notes*/
function Notes(){
    var x= document.getElementById('choices');
    if(x.style.display=='none')
    {
        document.getElementById("tcc200").style.display = "none";
        document.getElementById("choices").style.display = "block";
    }
    else{
        document.getElementById("tcc200").style.display = "block";
        document.getElementById("choices").style.display = "none";
    }
}
/*toggle courses*/
function course(){
    var x= document.getElementById('cour');
    if(x.style.display=='none')
    {
        document.getElementById("tcc200").style.display = "none";
        document.getElementById("cour").style.display = "block";
    }
    else{
        document.getElementById("tcc200").style.display = "block";
        document.getElementById("cour").style.display = "none";
    }
}
/*toggle count*/
function pcount(){
    var x= document.getElementById('pcount');
    if(x.style.display=='none')
    {
        document.getElementById("tcc200").style.display = "none";
        document.getElementById("pcount").style.display = "block";
    }
    else{
        document.getElementById("tcc200").style.display = "block";
        document.getElementById("pcount").style.display = "none";
    }
}
/*search css*/
function css(){
    $('#fakebox').css({"margin-top":"0","padding-top": "4vh" });
}
/*search query result*/
function Query(query)
{
    {
        $.post
            ('query.php',
                { query : query.value },
                function(data)
                {
                    $('#result').html(data)
                }
            )
    }
}
/*add to cart*/
function addTo(addtocart)
{
    {
        $.post
            ('cart.php',
                { addtocart : addtocart.value },
                function(data)
                {
                    $('#cart4').html(data)
                }
            )
    }
}
/*show cart*/
function showCart(cartvalue){
    var x= document.getElementById('showcart');
    if(x.style.display=='none')
    {
        document.getElementById("fakebox").style.display = "none";
        document.getElementById("result").style.display = "none";
        document.getElementById("showcart").style.display = "block";
        $.post
            ('cart.php',
                { cartvalue : cartvalue.value },
                function(data)
                {
                    $('#showcart2').html(data)
                }
            )
    }
    else{
        document.getElementById("fakebox").style.display = "block";
        document.getElementById("result").style.display = "block";
        document.getElementById("showcart").style.display = "none";
    }
}
/*increase or decrease quantity*/
function add(add)
{
    $.post
            ('cart.php',
                { add : add.value },
                function(data)
                {
                    $('#gridcell3'+add.value).html(data)
                }
            )
            var sub= document.getElementById('subto').innerText;
            var subt=parseInt(sub);
            var cell4=document.getElementById('gridcell4'+add.value).innerText;
            var cell44=parseInt(cell4);
            var tot= subt-cell44;
            var x= document.getElementById('gridcell5'+add.value).innerText;
            var y= document.getElementById('gridcell3'+add.value).innerText;
            var a= parseInt(x);
            var b= parseInt(y)+1;
            var m= a*b;
            $('#gridcell4'+add.value).html(m)     
            var cart= document.getElementById('cart4').innerText;
            var cartv=parseInt(cart);
            var cartval=cartv+1;
            $('#cart4').html(cartval)
            var total= tot+m;
            $('#subto').html(total)
            return
}
function subtract(subtract)
{
    $.post
            ('cart.php',
                { subtract : subtract.value },
                function(data)
                {
                    $('#gridcell3'+subtract.value).html(data)
                }
            )
            var subo= document.getElementById('subto').innerText;
            var subto=parseInt(subo);
            var cell4o=document.getElementById('gridcell4'+subtract.value).innerText;
            var cell44o=parseInt(cell4o);
            var toto= subto-cell44o;
            var s= document.getElementById('gridcell5'+subtract.value).innerText;
            var t= document.getElementById('gridcell3'+subtract.value).innerText;
            var u= parseInt(s);
            var vo= parseInt(t);
            if(vo!=0)
            {
                var v=vo-1;
                var w= u*v;
                $('#gridcell4'+subtract.value).html(w)
                var carto= document.getElementById('cart4').innerText;
                var cartvo=parseInt(carto);
                var cartvalo=cartvo-1;
                $('#cart4').html(cartvalo)
                var totalo= toto+w;
                $('#subto').html(totalo)
                return
            }
}
/*empty cart*/
function empty(empty)
{
    $.post
            ('cart.php',
                { empty : empty.value },
                function(data)
                {
                    $('#cart4').remove()
                    $('#subt').remove()
                    $('#showcart3').html("Your cart is empty. Please <em>add</em> desired courses")
                }
            )
}
/*toggle post*/
function showpost(){
    var x= document.getElementById('post901');
    if(x.style.display=='none')
    {
        document.getElementById("post900").style.display = "none";
        document.getElementById("post901").style.display = "block";
    }
    else{
        document.getElementById("post900").style.display = "block";
        document.getElementById("post901").style.display = "none";
    }
}
/*adcategory*/
function adCategory(adcategory)
{
    $.post
            ('changecat.php',
                { adcategory : adcategory.value },
                function(data)
                {
                    $('#usedC').html(data)
                }
            )
}
/*create ad total*/
function dayN(day){
    var x=document.getElementById('vday12');
    var y=50;
    var m= (x.value)*y;
    $('#det904').html('Rs'+'&nbsp;'+m)
    return
}
/*show course content*/
function content3(course)
{
    {
        document.getElementById("cour100").style.display = "none";
        document.getElementById("post100").style.display = "none";
        document.getElementById("resrch100").style.display = "none";
        document.getElementById("requi100").style.display = "none";
        document.getElementById("content1").style.display = "block";
        $.post
            ('content.php',
                { course : course.value },
                function(data)
                {
                    $('#content1').html(data)
                }
            )
    }
}
function closeCon()
{
    document.getElementById("cour100").style.display = "grid";
    document.getElementById("post100").style.display = "block";
    document.getElementById("resrch100").style.display = "block";
    document.getElementById("requi100").style.display = "block";
    document.getElementById("content1").style.display = "none";
}
/*url visited */
function urlV(vurl)
{
    $.post
            ('urlvisit.php',
                { vurl : vurl.value },
                function(data)
                {
                    $('#blank555').html(data)
                }
            )
}
/*report ad*/
function reportAd(repad)
{
    $.post
            ('urlvisit.php',
                { repad : repad.value },
                function(data)
                {
                    $('#blank555').html(data)
                    $('.advideo').css('visibility','hidden')
                }
            )
}
/*toggle content */
function content(cnt)
{
    var x=document.getElementById("cont123"+cnt.value);
    if(x.style.display == 'none')
    {
        document.getElementById("cont123"+cnt.value).style.display = "block";
    }
    else{
        document.getElementById("cont123"+cnt.value).style.display = "none";
    }
}
function content2(cnt)
{
    var x=document.getElementById("cont12"+cnt.value);
    if(x.style.display == 'none')
    {
        document.getElementById("cont12"+cnt.value).style.display = "block";
    }
    else{
        document.getElementById("cont12"+cnt.value).style.display = "none";
    }
}
/*toggle read me content*/
function togFirst()
{
    var x= document.getElementById('f2');
    if(x.style.display=='none')
    {
        document.getElementById("f3").style.display = "none";
        document.getElementById("f4").style.display = "none";
        document.getElementById("f2").style.display = "block";
    }
}
function togSec()
{
    var x= document.getElementById('f3');
    if(x.style.display=='none')
    {
        document.getElementById("f2").style.display = "none";
        document.getElementById("f4").style.display = "none";
        document.getElementById("f3").style.display = "block";
    }
}
function togThird()
{
    var x= document.getElementById('f4');
    if(x.style.display=='none')
    {
        document.getElementById("f3").style.display = "none";
        document.getElementById("f2").style.display = "none";
        document.getElementById("f4").style.display = "block";
    }
}