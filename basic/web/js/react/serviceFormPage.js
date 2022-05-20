let currentService = $('#service-page-form > div[data-serviceForm-type="main"]').data('service');

class ServiceForm extends React.Component{
    constructor(props){
        super(props);
    }
    componentDidMount(){
        
    }
    render(){
        return (
            <React.Fragment>
                <header id="formUI"></header>
                <main id="formUI"></main>
                <footer id="formUI"></footer>
            </React.Fragment>
        );
    }
}

ReactDOM.render(<ServiceForm />, document.querySelector(''));
