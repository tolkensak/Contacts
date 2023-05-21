
class FavCount {
    display(){
        document.getElementById('fav-count').innerText=document.querySelectorAll('[data-fav="1"]').length;
    }
};

window.onload=function(){
    const favCount=new FavCount;

    favCount.display();

    for(const btn of document.getElementsByClassName('fav-btn')){
        btn.onclick=function(){
            const request=new XMLHttpRequest(),
                fav=parseInt(this.dataset.fav)?0:1;

            request.open('GET', '?route=favcount&contactid='+this.dataset.contactid+'&fav='+fav);
            request.send();

            this.dataset.fav=fav;
            this.src='image/fav-'+fav+'.png';

            favCount.display();
        };
    }
};
