#expertPage{ padding-bottom: 100%; }

#expert-head {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	grid-template-rows: repeat(4, 1fr);
	grid-column-gap: 20px;
	grid-row-gap: 20px;
	width: 75%;
	background: white;
	height: 505px;
	margin-left: 12%;
}

#expert-head > div:nth-last-child(4) {grid-area: 1 / 1 / 4 / 2;margin-top: 24%;margin-left: 12%;}
#expert-head > div:nth-last-child(3) {grid-area: 1 / 2 / 2 / 5;margin-left: 11%;margin-top: 2%;}
#expert-head > div:nth-last-child(2) {grid-area: 2 / 2 / 3 / 5;margin-left: 11%;margin-top: -6%;}
#expert-head > div:nth-last-child(1) {grid-area: 3 / 2 / 4 / 5;margin-left: 12%;font-size: 80%;margin-top: -2%;}

#expert-head > div:nth-child(1) img{
	width: 274px;
    height: 276px;
    object-fit: cover;
    border-radius: 48%;
}

#expert-head > div:not(:nth-child(1)) * {color: black;}
#expert-head > div:nth-last-child(3) h2{font-size: 120%;}
#expert-head > div:nth-last-child(3) span{font-size: 110%;}
#expert-head > div:nth-last-child(3) h4{font-style: italic;font-size: 120%;font-weight: 600;}

#expert-head > div:nth-child(3) ul{
	font-size: 90%;
}
#expert-head > div:nth-child(3) ul li strong{display: initial;}

#expert-head > div:nth-child(3) ul li[data-field='0']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAA1ElEQVRYhe2UMQrCMBSG/9R4hroWseBsERxcPE31CoJOnsGK19DRSUTBHkAsiKN3sOlzE5UKpqnG4X1jQl4+fpIfYCwjihxqzZK6IExA6AEAHFoJheF+4J++LtCeH7xMVbYA3Jeti6S0s+s3zzrzHF0BpeQIgEvAQlLqSUo9QCwB1K6iOtad95RAECWkO6AIcdi436udQNnIvMVHwzLJS9h6AizAAkYCwTTZBNFxbU0AgjIBx6i8cnvgU+LQ75qcfyvwq0oG/uARchWzgHUB/oYMw9wAdo05wQeCuG4AAAAASUVORK5CYII=');}
#expert-head > div:nth-child(3) ul li[data-field='1']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAAcklEQVRYhWNgGAWjYIABIzZBkxm3/9PCsjMZqhj2MdHCIlIACz5JbC4mB+AL0QEPgQF3AN4oQAbYghEWRfjkCIEBD4FRBwy4A4hOhPgSFSXlxdAJgdFsOOoAWoHRbDjgDsAbBbRqGyKDAQ+BUTAKBhwAAHzWIEaNngRQAAAAAElFTkSuQmCC');}
#expert-head > div:nth-child(3) ul li[data-field='2']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAADwElEQVRYhe2XT2wUdRTHP29nl9YqBzC1LbEHYKd/bKlit1RBkm1SjSYm8sdw8SKYutOLRkIixh42pp6MxouwawNN1ETSGBQvmkBKE0SknR6oVP7s2h4ktUo8mEJrt915Hnao291Oly6EeOB72vf/O29+835v4T7uAJuPJso3H02U30kOX7GBrT1jFUaKfiNFf2vPWEWxeaSYoJZPxivVmD8FNLhprhiGtp/vMK/ddQKhw8mTiE6oaBL41Sf8qY7EgQ0iDAOo0gyMiU8jjvIIsFFUgqisszuDzxZNoDn+S5VoYMIj8Ke5Ev8LAIHZ+e8UnlrKT2Vu3XDksd+9aviXIwCBTW61S6DHVcUUqAH9a1XA2Tm015wC2Hbk8nOzc76vQR5WuCqiCZBdKPWi/kagWAKyCRSUftuq6fLyOvta3RTQnq1rjiXWCNSj0gic9Ir1/ArC0dN+Ud0OgOrPyxNdgrrqSOaHPENUPevkG1QlFEu8fKOy+iLwEoBPZGSlBP6L0V2hyuRIczy5A9W8M7dI8eShK9t9Ih8i0uKqxkC77Ih5DBHN9g1HT/tvVD16DGW3bZn5h1lVWuLJVxTeA9a72kFU9tudwbMLRBex8RlPuMXTKvrmzNpUvW3VfJlbfMFf6fdsgYgOWeYXM2tTdYq8ASiwRUQfz3ZbRGB1idGDMgEYolwa3dOQ8so/EG2bH7LMQ54EXIzuaUgZyjUy3Z70T5f2ehIY2Lv+H/XJRwCoRAslv104OO8AKHxwbn/1jCcBgLkHbsZQriNsDR1OhAslX/L9Z6EllnwekRaU63Nl0/Fce4E5kEEolrh1Bj5G+RvhXeBz2zL3Zdtsy3wrVy6UO68DgemyCEK5IGfsTnPgll7hoJPWT11xBOVFD9siecgKfg/YCOWB6bLIsgTCveOlghwAcES7cxzX+A1d5Yq1CN962PJkFXkfQJAD4d7xUk8CU7PpDtAqIA1a19A3upBkyDIPDlq1F1yxD9jR9NmFB90nftvB92pWBxbkhr7RVSjVGbVW3Zyd35dds+hBVBC3OYiWnGCheHI3SDdoLYAPtg5a5rmV1N8SSzztwI+uOKoiXcOvbzyR+yD5d4GI2pb51UOTvzUCJwAc1aaVFF8cI8ftyWDTcCT4zVJd9LylBqJt8ypyBkBFVkxAkMzIVf2BqDhefgXmQOYaFqEtFL/anb2QlAScne4ewLYjl1fnLiQKYRQQvbg80WVwL1ay//dS6oV7upZ7obVnrCKdTp8CMAyj/XzHhj+KzVU07sZfs/v4F9mXsmylmUOtAAAAAElFTkSuQmCC');}
#expert-head > div:nth-child(3) ul li[data-field='3']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACcElEQVRYhe2Wz0tUURTHP+fND7JR+4GhAw5ROCS6CBoHIly0qmVBrsptOBbNOmgTBLYKMRuYWYcuqn+htcRMEIKCzNSmH5ouJHJA0plvC0cze+9NE/5Y5AcuXM67537PO/e8dy4ccsgBY5uTvmxR+ylcSMUNwNlPUTeCHvaVQiresptCfdnid6B5p90tA2VMY7spDoB4CpR3mv+ogc2z8SOZKcUU1CjiSs30mmrlfuFO91w93506DddAMlOKKaB3iBtAS21cNycwlcyUYo3u5x/AQznJbHEwmS0OIhmAghoFThq8tEowapVgFHglOEFAT7z8vPAqQgCSHaWbgucAyWxJeZjYSnslmM7fPbMAkMjNpk2hAcFVT79/yoA7fl9Ha6Ob+QaQH+qaMDEo0618qmuyZs4AKLA+nsjNRhO52agRGgfAeObj54rvEWD2K31DG6aQqo/XzLkGDJhCA9tWfxRrI15+XjR8BFPD5z5X1gP9JiYNFg0WBRMyp//tUM98o/u59YIyYqwwHH/Q6GZ+JLLFEYM0EAH//0AEI72b4gAG9zbFt+NVA8371R0PvBseOF4Xkm/AKhvdqzbXsoklmbMotGBiycyWjMq8BUILb26f/VpPzK3hedXAsdr4LdZaN9iI2kAI4UClQl+2uCJ4D/rgyOZkmjbHpiNfPs2V2zsfyaOwXRtFb2amOdwUbgquqoUgreAcVbUakdlxR5wC2oTaDOsQdCJOY3TgXlM/ai+69Wx7Bur2/r+l98VM+MhyOGZyzhnqEeo26BWcB5q2r92TALxI5AohaL3giItV7JIDl/OpePte63pT535wyP/HTwwu8l6b1mM3AAAAAElFTkSuQmCC');}
#expert-head > div:nth-child(3) ul li[data-field='4']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAEC0lEQVRYhe2W3U8cZRTGf2dmlwWxLTS1KUj5EFeklFIoC5qGmCZKJV7YC69s0gQ1XUpqLE1Mql6oiUYTE6vFwkL8+AOqF0aDGE1aY4zhq6XUIrBUW6Rg/CgbKgLLzh4vdqkrsrPdJb0xPslkJnPO+5znfc77zjvwP9YAT6e/zNPpL1sLh2NNCiyOhAUFDqZKIakOrHzff4cZ5AqAlUbBuSfcv6bCY6QqwFyiGcgAMhxBDqXKk5IDd5/wu7LSuAxsiZL8kulyFJxpLFpIlislB7Kc7Ae2oNqHap/C5j8WQo+nwpVaCwx9JvrwJsJxAISjqCbtaNICPL7xh1HZoXBVjcBHt/989RQwAZRV+cbrb7kARVsARPTtAW/10pmX9oRQPQlgCi3J8tladv+7FzcuLblyMdmKpTlAMcJzwNxiOC3/QnPBDEB525VslxGcADJRXgMuYco0Fj85nYtT3z5Vds1WwM4PfsxyLISeRcgH8hVyBPKIbLPVRr3T73U/HfuqusPfinI4Tp15hUmBaWACZSKU7nhjsLEo4AAYbCwKeHxjA4ocBdJjbJlVmBSVKUSnUCZBpk3TOLWygmmYr1ih8ChoDkIeKrkqmhudyHoBN5FrQUT3DzYWBW44sIyqttE60zA+VsgGehbDaQ3LNqeKaHs+A2oFZqxw+NGzzSVfL8f/tQZqff5tFnQDWxWGEaNhwFs8kUrxytaRXMNpdglUgEwbWA29TSXnY3NWXYSVrSO5ptPsBspRpsJqNpxtvmsomeJVJ8dKDVO6gXxgRMXYu9pE4u6CqHWfALtXs84OuzrGakXlU2ATqn2WSx6Jd1jF/Q5caC6YCd72517QLoVswzA+r2obrUtUvKpttE5UTgObQLuCmfN77E5K2w/R0IGKOZXZfQjjQIZhONYlEhDNyUAYV5ndN3SgYs42PxEhAMqdgKqEehMKCAV7AEXJuxnqmxCwoZzIjC4NeEt+S5Tde7j0d+AHIF3CG7Ynyk/8S6ZaAwIqfbGvo9v1OIAJLT1N7uG/o9ILWqyitcA5O/qEDghSE7mHeyCyOzw+/+tWhLgeqLfgfLVvrGNH+/jmyCDtBRART2L+BKj2+b8DygR9ICzsFJUXgY1ACLQ9SnOIiJvXVPRlQxlU5CvgYn+T27YNtgJ2vzeybnHJDACGIpcFLYyGvjDhyLLt0Xa8BTwEEJMbdjmtrG+evPd6vBq2a2A+6PAYokZEqRYijCs8P+B1/+Mwigqp93SOPagqJ0S1NBoyFkKOauB0vBq2a0BEl3t4XeFYYJHtK4vHou/gPV8GFqlUOAZEZq1aY1vDLljd4f8QZVZl6YUB77Zpu9yV2NUxnCPqfBVhfb/X/VgyY2/gvvbvCxNn3XqO/zb+Asbrgm++n2iqAAAAAElFTkSuQmCC');}

#add-but{
   text-align: center;
   color:white;
   background-color:#0079bf;
   border: none;
   font-size: 62%;
   padding: 10px;
   margin-left: 2%;
   margin-top: 6%;
}

#expert-body{
	width: 86%;
	margin-left: 9%;
}
#expert-body > ul {
 list-style-type: none;
 width: 100%;
}
#expert-body > ul li {
 margin: 10px;
 padding: 5px;
 width: 45%;
 display: inline-table;
}

#expert-body > ul li h2{
 font-size: 150%;
}
#expert-body > ul li div{
 padding-top: 2%;
 padding-bottom: 2%;
}
#expert-body > ul li div[data-format='aboutContent'] p{
 text-indent: 2%;
 font-size: 110%;
}
#expert-body > ul li div[data-format='aboutContent'] ul{
 margin-left: -9%;
 font-size: 115%;
}
#expert-body > ul li div[data-format='aboutContent'] ul li{
 display: block;
}
#expert-body > ul li div[data-format='aboutContent'] ul li i{
 color: gray;
}

#expert-body > ul li div[data-format='list[info]'] span{font-size: 110%;}
#expert-body > ul li div[data-format='list[info]'] ul{
 margin-left: -8%;
 font-size: 115%;
 margin-top: 4%;
}
#expert-body > ul li div[data-format='list[info]'] ul li{
 display: block;
 font-size: 100%;
}

#expert-body > ul li div[data-format='list[]'] ul{
 margin-left: -8%;
 font-size: 115%;
 margin-top: 4%;
 width: 120%;
}
#expert-body > ul li div[data-format='list[]'] ul li{
 display: block;
 font-size: 100%;
}

#expert-body > ul li div[data-format='priceList'] ul{margin-left: -8%;}
#expert-body > ul li div[data-format='priceList'] ul li{margin-top: 4%;display: block;width: 100%;}
#expert-body > ul li div[data-format='priceList'] ul li *{padding-bottom: 2%;}
#expert-body > ul li div[data-format='priceList'] ul li header{margin-left: 0%;color: black;font-size: 150%;font-weight: 600;}
#expert-body > ul li div[data-format='priceList'] ul li main{font-size: 90%;color: gray;}
#expert-body > ul li div[data-format='priceList'] ul li footer{font-size: 102%;font-style: italic;}


@media all and (max-width: 414px){
	#expertPage { height: calc(800px * 4); }
	#expert-head { width: 83%; height: 700px; }
	#expert-head > div:nth-last-child(4) {
		margin-top: 4%;
		margin-left: 5%;
		width: 182%;
		height: 236px;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 139%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-last-child(2) {
		grid-area: 2 / 1 / 3 / 5;
		margin-left: 3%;
		margin-top: -12%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 66%;
	}
	#expert-head > div:nth-last-child(1) {
		grid-area: 3 / 2 / 3 / 1;
		margin-left: 6%;
		font-size: 52%;
		margin-top: -16%;
		width: 194%;
	}
	#expert-head > div:nth-child(1) img {
		width: calc(274px / 2);
		height: calc(276px / 2);
		margin-left: 22%;
		margin-top: 7%;
	}
	#expert-head > div:nth-last-child(3) {
		grid-area: 1 / 2 / 2 / 1;
		margin-top: 160%;
		width: 183%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -19%;}
	#expert-body { margin-left: 0%; }
	#expert-body > ul li {
		width: 88%;
		display: block;
	}
	
}
@media all and (min-width: 414px) and (max-width: 768px){
    #expertPage {height: calc(864px * 3);}
    #expert-head {width: 81%;height: 700px;}
	#expert-head > div:nth-last-child(4) {
		margin-top: 4%;
		margin-left: 38%;
		width: 182%;
		height: 236px;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 143%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-last-child(2) {
		grid-area: 2 / 1 / 3 / 5;
		margin-left: 11%;
		margin-top: -9%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 66%;
	}
	#expert-head > div:nth-last-child(1) {
		grid-area: 3 / 2 / 3 / 1;
		margin-left: 33%;
		font-size: 52%;
		margin-top: -11%;
		width: 194%;
	}
	#expert-head > div:nth-child(1) img {
		width: calc(274px / 2);
		height: calc(276px / 2);
		margin-left: 22%;
		margin-top: 7%;
	}
	#expert-head > div:nth-last-child(3) {
		grid-area: 1 / 2 / 2 / 1;
		margin-top: 160%;
		width: 183%;
		margin-left: 31%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -12%;}
	#expert-body {margin-left: 3%;}
	#expert-body > ul li {
		width: 88%;
		display: block;
	}
}
@media all and (min-width: 600px) and (max-width: 768px){
    #expertPage {height: calc(800px * 3);}
    #expert-head {width: 80%;height: 700px;}
	#expert-head > div:nth-last-child(4) {
		margin-top: 4%;
		margin-left: 85%;
		width: 182%;
		height: 236px;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 139%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-last-child(2) {
		grid-area: 2 / 1 / 3 / 5;
		margin-left: 19%;
		margin-top: -6%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 66%;
	}
	#expert-head > div:nth-last-child(1) {
		grid-area: 3 / 2 / 3 / 1;
		margin-left: 64%;
		font-size: 52%;
		margin-top: -16%;
		width: 194%;
	}
	#expert-head > div:nth-child(1) img {
		width: calc(274px / 2);
		height: calc(276px / 2);
		margin-left: 22%;
		margin-top: 7%;
	}
	#expert-head > div:nth-last-child(3) {
		grid-area: 1 / 2 / 2 / 1;
		margin-top: 164%;
		width: 183%;
		margin-left: 72%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -11%;}
	#expert-body {margin-left: 5%;}
	#expert-body > ul li {
		width: 88%;
		display: block;
	}
}
@media all and (min-width: 768px) and (max-width: 800px){
	#expertPage {height: calc(712px * 3);}
	#expert-head {width: 80%;height: 549px;}
	#expert-head > div:nth-last-child(4) {
		margin-top: 4%;
		margin-left: 5%;
		width: 187%;
		height: 236px;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 139%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-last-child(2) {
		margin-left: 25%;
		margin-top: -5%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 66%;
	}
	#expert-head > div:nth-last-child(1) {
		margin-left: 25%;
		font-size: 49%;
		margin-top: 2%;
		width: 194%;
	}
	#expert-head > div:nth-child(1) img {
		width: calc(274px / 2);
		height: calc(276px / 2);
		margin-left: 22%;
		margin-top: 7%;
	}
	#expert-head > div:nth-last-child(3) {
		margin-top: 7%;
		width: 183%;
		margin-left: 26%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -9%;}
	#expert-body { margin-left: 0%; }
	#expert-body > ul li {
		width: 88%;
		display: block;
	}
}
@media all and (min-width: 800px) and (max-width: 1024px){
	#expertPage {height: calc(700px * 3);}
	#expert-head {width: 83%;height: 545px;}
	#expert-head > div:nth-last-child(4) {
		margin-top: 4%;
		margin-left: 5%;
		width: 182%;
		height: 236px;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 139%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-last-child(2) {
		grid-area: 2 / 1 / 3 / 5;
		margin-left: 40%;
		margin-top: 1%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 66%;
	}
	#expert-head > div:nth-last-child(1) {
		margin-left: 20%;
		font-size: 61%;
		margin-top: 0%;
		width: 194%;
	}
	#expert-head > div:nth-child(1) img {
		width: calc(274px / 2);
		height: calc(276px / 2);
		margin-left: 22%;
		margin-top: 7%;
	}
	#expert-head > div:nth-last-child(3) {
		margin-top: 5%;
		width: 183%;
		margin-left: 20%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -7%;}
	#expert-body {margin-left: 6%;}
	#expert-body > ul li {
		width: 88%;
		display: block;
	}
}
@media all and (min-width: 1024px) and (max-width: 1280px){
	#expertPage {height: calc(800px * 2);}
	#expert-head > div:nth-last-child(4) {
		width: 100%;
	}
	#expert-head > div:nth-last-child(3) {
		margin-top: 5%;
	}
	#expert-head > div:nth-last-child(3) h2 {
		font-size: 140%;
	}
	#expert-head > div:nth-last-child(3) span {
		font-size: 92%;
	}
	#expert-head > div:nth-last-child(3) h4 {
		font-size: 85%;
	}
	#expert-head > div:nth-child(3) ul {
		font-size: 70%;
	}
	#expert-head > div:nth-last-child(1) {
		font-size: 67%;
	}
	#expert-body > ul li div[data-format='aboutContent'] ul {margin-left: -6%;}
	#expert-body > ul li:nth-child(1),  #expert-body > ul li:nth-last-child(1){
		width: 87%;
		display: block;
	}
}
@media all and (min-width: 1280px) and (max-width: 1366px){
	#expertPage {height: calc(650px * 2);}
	#expert-body > ul li div[data-format='aboutContent'] ul, #expert-body > ul li div[data-format='priceList'] ul {margin-left: -5%;}
	#expert-body > ul li:nth-child(1),  #expert-body > ul li:nth-last-child(1){
		width: 87%;
		display: block;
	}
}
@media all and (min-width: 1366px) and (max-width: 1440px){
	#expertPage {height: calc(650px * 2);}
}
@media all and (min-width: 1440px) and (max-width: 1536px){
	#expertPage {height: calc(434px * 2);}
}
