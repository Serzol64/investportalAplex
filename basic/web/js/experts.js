#experts{padding-bottom: 300%;}

#experts-search{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: 150px 300px auto;
  grid-column-gap: 15px;
  grid-row-gap: 15px;
  margin-left: 4%;
}
#experts-search > *{
  padding-top: 2%;
  padding-bottom: 2%;
}

#experts-search > header{
  grid-area: 1 / 1 / 2 / 4;
}
#experts-search > main{
  grid-area: 2 / 1 / 3 / 2; 
}
#experts-search > footer{
  grid-area: 2 / 2 / 3 / 4;
  width: 80%;
}

#consultQ{
  width: 86%;
  font-size: 150%;
  padding-top: 1%;
  padding-bottom: 1%;
  text-indent: 2%;
}

#experts-search > footer i{
  margin-top: 2%;
  display: block;
  font-size: 120%;
  color: gray;
}
.result{
  list-style-type: none;
  display: block;
  margin-top: 4%;
  margin-left: -4%;
}

.result > li{
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  grid-template-rows: repeat(4, 1fr);
  grid-column-gap: 8px;
  grid-row-gap: 8px;
  margin-top: 4%;
  background-color: white;
}

.result > li *[data-block='header']{
  grid-area: 1 / 1 / 3 / 2;
  border-radius: 50%;
  border: solid 2px gray;
  padding: 25%;
  width: 50px;
  height: 50px;
  object-fit: contain;
  margin-top: 22%;
  margin-left: 12%;
}

.searchComponent{
    background-color: white;
    width: 68%;
    display: block;
    margin-top: 17%;
    margin-left: 25%;
}

.searchComponent > #search-header, .searchComponent > #search-footer{display: block;padding-top: 10px;padding-bottom: 10px;}

#search-header > ul, #search-footer > ul{list-style-type: none;}

#search-header > ul li, #search-footer > ul li{display: block;margin-top: 5%;}

#search-header > ul li label{font-size: 90%;color: gray;}
#search-header > ul li *[data-formState='yes']{font-size: 130%;display: block;margin-top: 2%;width: 90%;padding: 1%;}
#search-footer > ul li input{
}
#search-footer > ul li label{font-size: 122%;}

.result > li *[data-block='content']{
  grid-area: 1 / 2 / 3 / 9;
  margin-left: 7%;
}

*[data-block='content'] > h3 {font-size: 160%;}
*[data-block='content'] > h3 a{color: #0079bf;}
*[data-block='content'] > span{font-size: 110%;}
*[data-block='content'] > h4{font-style: italic;font-size: 120%;font-weight: 600;}


.result > li *[data-block='footer']{
  grid-area: 6 / 2 / 7 / 9;
  margin-left: 4%;
  margin-top: -36%;
}

*[data-block='footer']{
	font-size: 120%;
	list-style-position: inside;
}
*[data-block='footer'] > li[data-field='0']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAA1ElEQVRYhe2UMQrCMBSG/9R4hroWseBsERxcPE31CoJOnsGK19DRSUTBHkAsiKN3sOlzE5UKpqnG4X1jQl4+fpIfYCwjihxqzZK6IExA6AEAHFoJheF+4J++LtCeH7xMVbYA3Jeti6S0s+s3zzrzHF0BpeQIgEvAQlLqSUo9QCwB1K6iOtad95RAECWkO6AIcdi436udQNnIvMVHwzLJS9h6AizAAkYCwTTZBNFxbU0AgjIBx6i8cnvgU+LQ75qcfyvwq0oG/uARchWzgHUB/oYMw9wAdo05wQeCuG4AAAAASUVORK5CYII=');}
*[data-block='footer'] > li[data-field='1']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAAcklEQVRYhWNgGAWjYIABIzZBkxm3/9PCsjMZqhj2MdHCIlIACz5JbC4mB+AL0QEPgQF3AN4oQAbYghEWRfjkCIEBD4FRBwy4A4hOhPgSFSXlxdAJgdFsOOoAWoHRbDjgDsAbBbRqGyKDAQ+BUTAKBhwAAHzWIEaNngRQAAAAAElFTkSuQmCC');}
*[data-block='footer'] > li[data-field='2']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAADwElEQVRYhe2XT2wUdRTHP29nl9YqBzC1LbEHYKd/bKlit1RBkm1SjSYm8sdw8SKYutOLRkIixh42pp6MxouwawNN1ETSGBQvmkBKE0SknR6oVP7s2h4ktUo8mEJrt915Hnao291Oly6EeOB72vf/O29+835v4T7uAJuPJso3H02U30kOX7GBrT1jFUaKfiNFf2vPWEWxeaSYoJZPxivVmD8FNLhprhiGtp/vMK/ddQKhw8mTiE6oaBL41Sf8qY7EgQ0iDAOo0gyMiU8jjvIIsFFUgqisszuDzxZNoDn+S5VoYMIj8Ke5Ev8LAIHZ+e8UnlrKT2Vu3XDksd+9aviXIwCBTW61S6DHVcUUqAH9a1XA2Tm015wC2Hbk8nOzc76vQR5WuCqiCZBdKPWi/kagWAKyCRSUftuq6fLyOvta3RTQnq1rjiXWCNSj0gic9Ir1/ArC0dN+Ud0OgOrPyxNdgrrqSOaHPENUPevkG1QlFEu8fKOy+iLwEoBPZGSlBP6L0V2hyuRIczy5A9W8M7dI8eShK9t9Ih8i0uKqxkC77Ih5DBHN9g1HT/tvVD16DGW3bZn5h1lVWuLJVxTeA9a72kFU9tudwbMLRBex8RlPuMXTKvrmzNpUvW3VfJlbfMFf6fdsgYgOWeYXM2tTdYq8ASiwRUQfz3ZbRGB1idGDMgEYolwa3dOQ8so/EG2bH7LMQ54EXIzuaUgZyjUy3Z70T5f2ehIY2Lv+H/XJRwCoRAslv104OO8AKHxwbn/1jCcBgLkHbsZQriNsDR1OhAslX/L9Z6EllnwekRaU63Nl0/Fce4E5kEEolrh1Bj5G+RvhXeBz2zL3Zdtsy3wrVy6UO68DgemyCEK5IGfsTnPgll7hoJPWT11xBOVFD9siecgKfg/YCOWB6bLIsgTCveOlghwAcES7cxzX+A1d5Yq1CN962PJkFXkfQJAD4d7xUk8CU7PpDtAqIA1a19A3upBkyDIPDlq1F1yxD9jR9NmFB90nftvB92pWBxbkhr7RVSjVGbVW3Zyd35dds+hBVBC3OYiWnGCheHI3SDdoLYAPtg5a5rmV1N8SSzztwI+uOKoiXcOvbzyR+yD5d4GI2pb51UOTvzUCJwAc1aaVFF8cI8ftyWDTcCT4zVJd9LylBqJt8ypyBkBFVkxAkMzIVf2BqDhefgXmQOYaFqEtFL/anb2QlAScne4ewLYjl1fnLiQKYRQQvbg80WVwL1ay//dS6oV7upZ7obVnrCKdTp8CMAyj/XzHhj+KzVU07sZfs/v4F9mXsmylmUOtAAAAAElFTkSuQmCC');}
*[data-block='footer'] > li[data-field='3']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACcElEQVRYhe2Wz0tUURTHP+fND7JR+4GhAw5ROCS6CBoHIly0qmVBrsptOBbNOmgTBLYKMRuYWYcuqn+htcRMEIKCzNSmH5ouJHJA0plvC0cze+9NE/5Y5AcuXM67537PO/e8dy4ccsgBY5uTvmxR+ylcSMUNwNlPUTeCHvaVQiresptCfdnid6B5p90tA2VMY7spDoB4CpR3mv+ogc2z8SOZKcUU1CjiSs30mmrlfuFO91w93506DddAMlOKKaB3iBtAS21cNycwlcyUYo3u5x/AQznJbHEwmS0OIhmAghoFThq8tEowapVgFHglOEFAT7z8vPAqQgCSHaWbgucAyWxJeZjYSnslmM7fPbMAkMjNpk2hAcFVT79/yoA7fl9Ha6Ob+QaQH+qaMDEo0618qmuyZs4AKLA+nsjNRhO52agRGgfAeObj54rvEWD2K31DG6aQqo/XzLkGDJhCA9tWfxRrI15+XjR8BFPD5z5X1gP9JiYNFg0WBRMyp//tUM98o/u59YIyYqwwHH/Q6GZ+JLLFEYM0EAH//0AEI72b4gAG9zbFt+NVA8371R0PvBseOF4Xkm/AKhvdqzbXsoklmbMotGBiycyWjMq8BUILb26f/VpPzK3hedXAsdr4LdZaN9iI2kAI4UClQl+2uCJ4D/rgyOZkmjbHpiNfPs2V2zsfyaOwXRtFb2amOdwUbgquqoUgreAcVbUakdlxR5wC2oTaDOsQdCJOY3TgXlM/ai+69Wx7Bur2/r+l98VM+MhyOGZyzhnqEeo26BWcB5q2r92TALxI5AohaL3giItV7JIDl/OpePte63pT535wyP/HTwwu8l6b1mM3AAAAAElFTkSuQmCC');}
*[data-block='footer'] > li[data-field='4']{list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAEC0lEQVRYhe2W3U8cZRTGf2dmlwWxLTS1KUj5EFeklFIoC5qGmCZKJV7YC69s0gQ1XUpqLE1Mql6oiUYTE6vFwkL8+AOqF0aDGE1aY4zhq6XUIrBUW6Rg/CgbKgLLzh4vdqkrsrPdJb0xPslkJnPO+5znfc77zjvwP9YAT6e/zNPpL1sLh2NNCiyOhAUFDqZKIakOrHzff4cZ5AqAlUbBuSfcv6bCY6QqwFyiGcgAMhxBDqXKk5IDd5/wu7LSuAxsiZL8kulyFJxpLFpIlislB7Kc7Ae2oNqHap/C5j8WQo+nwpVaCwx9JvrwJsJxAISjqCbtaNICPL7xh1HZoXBVjcBHt/989RQwAZRV+cbrb7kARVsARPTtAW/10pmX9oRQPQlgCi3J8tladv+7FzcuLblyMdmKpTlAMcJzwNxiOC3/QnPBDEB525VslxGcADJRXgMuYco0Fj85nYtT3z5Vds1WwM4PfsxyLISeRcgH8hVyBPKIbLPVRr3T73U/HfuqusPfinI4Tp15hUmBaWACZSKU7nhjsLEo4AAYbCwKeHxjA4ocBdJjbJlVmBSVKUSnUCZBpk3TOLWygmmYr1ih8ChoDkIeKrkqmhudyHoBN5FrQUT3DzYWBW44sIyqttE60zA+VsgGehbDaQ3LNqeKaHs+A2oFZqxw+NGzzSVfL8f/tQZqff5tFnQDWxWGEaNhwFs8kUrxytaRXMNpdglUgEwbWA29TSXnY3NWXYSVrSO5ptPsBspRpsJqNpxtvmsomeJVJ8dKDVO6gXxgRMXYu9pE4u6CqHWfALtXs84OuzrGakXlU2ATqn2WSx6Jd1jF/Q5caC6YCd72517QLoVswzA+r2obrUtUvKpttE5UTgObQLuCmfN77E5K2w/R0IGKOZXZfQjjQIZhONYlEhDNyUAYV5ndN3SgYs42PxEhAMqdgKqEehMKCAV7AEXJuxnqmxCwoZzIjC4NeEt+S5Tde7j0d+AHIF3CG7Ynyk/8S6ZaAwIqfbGvo9v1OIAJLT1N7uG/o9ILWqyitcA5O/qEDghSE7mHeyCyOzw+/+tWhLgeqLfgfLVvrGNH+/jmyCDtBRART2L+BKj2+b8DygR9ICzsFJUXgY1ACLQ9SnOIiJvXVPRlQxlU5CvgYn+T27YNtgJ2vzeybnHJDACGIpcFLYyGvjDhyLLt0Xa8BTwEEJMbdjmtrG+evPd6vBq2a2A+6PAYokZEqRYijCs8P+B1/+Mwigqp93SOPagqJ0S1NBoyFkKOauB0vBq2a0BEl3t4XeFYYJHtK4vHou/gPV8GFqlUOAZEZq1aY1vDLljd4f8QZVZl6YUB77Zpu9yV2NUxnCPqfBVhfb/X/VgyY2/gvvbvCxNn3XqO/zb+Asbrgm++n2iqAAAAAElFTkSuQmCC');}


.result > li *[data-block='alert']{
  grid-area: 7 / 2 / 9 / 9;
  margin-left: 7%;
}

@media all and (max-width: 414px){
	#experts { height: calc(800px * 9); }
	#consultQ {
		width: 90%;
		font-size: 110%;
	}
	#experts-search > header {
		grid-area: 1 / 1 / 2 / 6;
	}
	#experts-search > main {
		grid-area: 2 / 1 / 3 / 6;
	}
	.searchComponent {
		background-color: white;
		width: 90%;
		display: block;
		margin-top: -27%;
		margin-left: 4%;
	}
	#experts-search > footer {
		grid-area: 3 / 1 / 4 / 6;
		width: 91%;
	}
	#experts-search > footer i {
		margin-top: 50%;
		margin-left: 7%;
	}
	.result > li *[data-block='header'] {
		grid-area: 1 / 1 / 2 / 6;
	}
	.result > li *[data-block='content'] {
		grid-area: 2 / 1 / 3 / 6;
		margin-left: 10%;
		width: 180%;
		margin-top: -23%;
	}
	.result > li *[data-block='footer'] {
		grid-area: 3 / 1 / 4 / 6;
		font-size: 90%;
		width: 180%;
		margin-left: -17%;
		margin-top: -16%;
	}
	.result > li *[data-block='alert'] {
		grid-area: 4 / 1 / 5 / 5;
		width: 254%;
		margin-top: 28%;
	}
}
@media all and (min-width: 414px) and (max-width: 768px){
	#experts {height: calc(800px * 11);}
	#consultQ {
		width: 90%;
		font-size: 110%;
	}
	#experts-search > header {
		grid-area: 1 / 1 / 2 / 6;
	}
	#experts-search > main {
		grid-area: 2 / 1 / 3 / 6;
	}
	.searchComponent {
		background-color: white;
		width: 90%;
		display: block;
		margin-top: -27%;
		margin-left: 4%;
	}
	#experts-search > footer {
		grid-area: 3 / 1 / 4 / 6;
		width: 91%;
	}
	#experts-search > footer i {
		margin-top: 50%;
		margin-left: 7%;
	}
	.result > li *[data-block='header'] {
		grid-area: 1 / 1 / 2 / 6;
	}
	.result > li *[data-block='content'] {
		grid-area: 2 / 1 / 3 / 6;
		margin-left: 10%;
		width: 180%;
		margin-top: -5%;
	}
	.result > li *[data-block='footer'] {
		grid-area: 3 / 1 / 4 / 6;
		font-size: 90%;
		width: 180%;
		margin-left: -9%;
		margin-top: 3%;
	}
	.result > li *[data-block='alert'] {
		grid-area: 4 / 1 / 5 / 5;
		width: 236%;
		margin-top: 28%;
		margin-left: 16%;
	}
}
@media all and (min-width: 600px) and (max-width: 768px){
    #experts {height: calc(800px * 13);}
	#consultQ {
		width: 90%;
		font-size: 110%;
	}
	#experts-search > header {
		grid-area: 1 / 1 / 2 / 6;
	}
	#experts-search > main {
		grid-area: 2 / 1 / 3 / 6;
	}
	.searchComponent {
		background-color: white;
		width: 90%;
		display: block;
		margin-top: -27%;
		margin-left: 4%;
	}
	#experts-search > footer {
		grid-area: 3 / 1 / 4 / 6;
		width: 91%;
	}
	#experts-search > footer i {
		margin-top: 50%;
		margin-left: 7%;
	}
	.result > li *[data-block='header'] {
		grid-area: 1 / 1 / 2 / 6;
	}
	.result > li *[data-block='content'] {
		grid-area: 1 / 2 / 3 / 9;
		margin-left: 50%;
		width: 180%;
		margin-top: 14%;
	}
	.result > li *[data-block='footer'] {
		grid-area: 3 / 2 / 7 / 9;
		font-size: 90%;
		width: 180%;
		margin-left: -18%;
		margin-top: -49%;
	}
	.result > li *[data-block='alert'] {
		width: 254%;
		margin-top: -80%;
		margin-left: 4%;
	}
}
@media all and (min-width: 768px) and (max-width: 800px){
    #experts { height: calc(800px * 9); }
	#consultQ {
		width: 90%;
		font-size: 110%;
	}
	#experts-search > header {
		grid-area: 1 / 1 / 2 / 6;
	}
	#experts-search > main {
		grid-area: 2 / 1 / 3 / 6;
	}
	.searchComponent {
		background-color: white;
		width: 90%;
		display: block;
		margin-top: -27%;
		margin-left: 4%;
	}
	#experts-search > footer {
		grid-area: 3 / 1 / 4 / 6;
		width: 91%;
	}
	#experts-search > footer i {
		margin-top: 50%;
		margin-left: 7%;
	}
	.result > li *[data-block='header'] {
	}
	.result > li *[data-block='content'] {
		margin-left: 10%;
		width: 119%;
		margin-top: -3%;
	}
	.result > li *[data-block='footer'] {
		font-size: 90%;
		width: 180%;
		margin-left: -17%;
		margin-top: -44%;
	}
	.result > li *[data-block='alert'] {
		width: 254%;
		margin-top: -2%;
		margin-left: -10%;
	}
}
@media all and (min-width: 800px) and (max-width: 1024px){
    #experts {height: calc(800px * 6);}
	#consultQ {
		width: 90%;
		font-size: 110%;
	}
	#experts-search > header {
		grid-area: 1 / 1 / 2 / 6;
	}
	#experts-search > main {
		grid-area: 2 / 1 / 3 / 6;
	}
	.searchComponent {
		background-color: white;
		width: 90%;
		display: block;
		margin-top: -27%;
		margin-left: 4%;
	}
	#experts-search > footer {
		grid-area: 3 / 1 / 4 / 6;
		width: 91%;
	}
	#experts-search > footer i {
		margin-top: 50%;
		margin-left: 7%;
	}
	.result > li *[data-block='header'] {
	}
	.result > li *[data-block='content'] {
		margin-left: 12%;
		width: 180%;
		margin-top: -2%;
	}
	.result > li *[data-block='footer'] {
		grid-area: 3 / 1 / 4 / 6;
		font-size: 130%;
		width: 180%;
		margin-left: -2%;
		margin-top: -16%;
	}
	.result > li *[data-block='alert'] {
		grid-area: 4 / 1 / 5 / 5;
		width: 254%;
		margin-top: 28%;
	}
}
@media all and (min-width: 1024px) and (max-width: 1280px){
    #experts {height: calc(800px * 3);}
	.result > li *[data-block='header'] {
		margin-top: 47%;
		margin-left: 35%;
	}
	.result > li *[data-block='content'] { margin-left: 16%; }
	.result > li *[data-block='footer'] {
		margin-left: 4%;
		margin-top: -59%;
		font-size: 94%;
	}
	.result > li *[data-block='alert'] {
		margin-left: 16%;
		margin-top: -2%;
	}
}
@media all and (min-width: 1280px) and (max-width: 1366px){
	#experts {height: calc(800px * 2);}
	.result > li *[data-block='header'] {
		margin-top: 47%;
		margin-left: 35%;
	}
	.result > li *[data-block='content'] { margin-left: 16%; }
	.result > li *[data-block='footer'] {
		margin-left: 8%;
		margin-top: -46%;
		font-size: 94%;
	}
	.result > li *[data-block='alert'] {
		margin-left: 16%;
		margin-top: -2%;
	}
}
@media all and (min-width: 1366px) and (max-width: 1440px){
	#experts {height: calc(800px * 2);}
	.result > li *[data-block='footer'] {
		margin-left: 4%;
		margin-top: -41%;
	}
}
@media all and (min-width: 1440px) and (max-width: 1536px){
	#experts {height: calc(800px * 2);}
}
