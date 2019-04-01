// In this example we also have two components - a picture and
// a picture list. The pictures are fetched from Instagram via AJAX.

var placeholder = document.createElement("li");
placeholder.className = "placeholder";
var dr;
var picturez;

var Picture = React.createClass({
    clickHandler: function(){

        // When the component is clicked, trigger the onClick handler that
        // was passed as an attribute when it was constructed:

        this.props.onClick(this.props.id);
    },

    dragStart: function(e) {
        this.dragged = e.currentTarget;
        dr = e.currentTarget;
        e.dataTransfer.effectAllowed = 'move';
        // Firefox requires dataTransfer data to be set
        e.dataTransfer.setData("text/html", e.currentTarget);
    },
    dragEnd: function(e) {
        this.dragged.style.display = "block";
        //this.dragged.parentNode.removeChild(placeholder);
        $(this.dragged).parents('ul').find('.placeholder').remove();
        // Update data

        console.log(picturez);
        var data = picturez;
        var from = Number(this.dragged.dataset.id);
        var to = Number(this.over.dataset.id);
        if(from < to) to--;
        if(this.nodePlacement == "after") to++;
        data.splice(to, 0, data.splice(from, 1)[0]);
        PictureList.setState({data: data});
    },
    dragOver: function(e) {
        e.preventDefault();

        this.dragged = dr; // fiksme
        this.dragged.style.display = "none";

        if(e.target.className == "placeholder") return;
        this.over = e.target;
        // Inside the dragOver method
        var relY = e.clientY - this.over.offsetTop;
        var height = this.over.offsetHeight / 2;
        var parent = e.target.parentNode;

        if(relY > height) {
            this.nodePlacement = "after";
            parent.insertBefore(placeholder, e.target.nextElementSibling);
        }
        else if(relY < height) {
            this.nodePlacement = "before"
            parent.insertBefore(placeholder, e.target);
        }
    },

    render: function(){

        var cls = 'picture ' + (this.props.favorite ? 'favorite' : '');

        return (

            <li draggable="true"
                onDragOver={this.dragOver}
                onDragEnd={this.dragEnd}
                onDragStart={this.dragStart}
                onClick={this.clickHandler}
                data-id={this.props.ind}>

                <img src={this.props.src} width="200" title={this.props.title} />
                {/* <input type="text" placeholder="popisek"/>*/}
            </li>

        );

    }

});

var PictureList = React.createClass({

    getInitialState: function(){

        // The pictures array will be populated via AJAX, and
        // the favorites one when the user clicks on an image:

        return { pictures: [], favorites: [] };
    },

    componentDidMount: function(){

        // When the component loads, send a jQuery AJAX request

        var self = this;

        // API endpoint for Instagram's popular images for the day

        var url = 'https://api.instagram.com/v1/media/popular?client_id=' + this.props.apiKey + '&callback=?';

        $.getJSON(url, function(result){
            console.log(result);
            if(!result || !result.data || !result.data.length){
                return;
            }

            var pictures = result.data.map(function(p){

                return {
                    id: p.id,
                    url: p.link,
                    src: p.images.low_resolution.url,
                    title: p.caption ? p.caption.text : '',
                    favorite: false
                };

            });

            // Update the component's state. This will trigger a render.
            // Note that this only updates the pictures property, and does
            // not remove the favorites array.

            picturez = pictures;
            self.setState({ pictures: pictures });

        });

    },

    pictureClick: function(id){

        // id holds the ID of the picture that was clicked.
        // Find it in the pictures array, and add it to the favorites

        var favorites = this.state.favorites,
            pictures = this.state.pictures;

        for(var i = 0; i < pictures.length; i++){

            // Find the id in the pictures array

            if(pictures[i].id == id) {

                if(pictures[i].favorite){
                    return this.favoriteClick(id);
                }

                // Add the picture to the favorites array,
                // and mark it as a favorite:

                favorites.push(pictures[i]);
                pictures[i].favorite = true;

                break;
            }

        }

        // Update the state and trigger a render
        this.setState({pictures: pictures, favorites: favorites});

    },

    favoriteClick: function(id){

        // Find the picture in the favorites array and remove it. After this,
        // find the picture in the pictures array and mark it as a non-favorite.

        var favorites = this.state.favorites,
            pictures = this.state.pictures;


        for(var i = 0; i < favorites.length; i++){
            if(favorites[i].id == id) break;
        }

        // Remove the picture from favorites array
        favorites.splice(i, 1);


        for(i = 0; i < pictures.length; i++){
            if(pictures[i].id == id) {
                pictures[i].favorite = false;
                break;
            }
        }

        // Update the state and trigger a render
        this.setState({pictures: pictures, favorites: favorites});

    },

    render: function() {

        var self = this;

        var pictures = this.state.pictures.map(function(p, i){
            return <Picture id={p.id} src={p.src} title={p.title} favorite={p.favorite} ind={i} onClick={self.pictureClick} />
        });

        if(!pictures.length){
            pictures = <p>Loading images..</p>;
        }

        var favorites = this.state.favorites.map(function(p){
            return <Picture id={p.id} src={p.src} title={p.title} favorite={true} onClick={self.favoriteClick} />
        });

        if(!favorites.length){
            favorites = <p>Click an image to mark it as a favorite.</p>;
        }

        return (

            <div>
                <h1>Popular Instagram pics</h1>
                <ul className="pictures"> {pictures} </ul>

                <h1>Your favorites</h1>
                <div className="favorites"> {favorites} </div>
            </div>

        );
    }
});


// Render the PictureList component, and add it to .container.
// I am using an API key for a Instagram test ap. Please generate and
// use your own from here http://instagram.com/developer/

ReactDOM.render(
    <PictureList apiKey="642176ece1e7445e99244cec26f4de1f" />,
    document.getElementById('example')
);