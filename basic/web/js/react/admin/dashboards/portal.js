const tabSwitcher = () => {
  $('.admin-dashboard > header #board-tabs section').click(function(e,t){
    let allBlock = [
      $('.admin-dashboard > header #board-tabs section'),
      $('.admin-dashboard > main ul li')
    ],
        cur_allBlock = [
      $('.admin-dashboard > header #board-tabs section').eq($(this).index()),
      $('.admin-dashboard > main ul li').eq($(this).index())
    ];
    
    for(let i = 0; i < allBlock.length; i++){
      allBlock[i].removeClass('active');
      cur_allBlock[i].addClass('active');
    }
  });
}
$(document).ready(tabSwitcher);

class BasicTab extends React.Component{
  render(){
    return (
      <React.Fragment>
        <section id="dashboard-content">
        </section>
      </React.Fragment>
    );
  }
}
class DataTab extends React.Component{
  render(){
	return(
		<React.Fragment>
			<section id="dashboard-content">
			</section>
		</React.Fragment>
	);
  }
}
class ContentTab extends React.Component{
  render(){
    return(
		<React.Fragment>
			<section id="dashboard-content">
			</section>
		</React.Fragment>
	);
  }
}
let cmps = [
  <BasicTab />,<DataTab />,<ContentTab />
];

for(let i = 0; i < cmps.length; i++){
  const tabContent = document.querySelectorAll('.admin-dashboard > main ul li');
  ReactDOM.render(cmps[i], tabContent[i]);
}
