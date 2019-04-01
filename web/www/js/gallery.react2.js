var colors = ["Red","Green","Blue","Yellow","Black","White","Orange"];
var placeholder = document.createElement("li");
placeholder.className = "placeholder";

var List = React.createClass({
    getInitialState: function() {
        return {data: this.props.data};
    },
    dragStart: function(e) {
        this.dragged = e.currentTarget;
        //console.log(this.dragged);
        e.dataTransfer.effectAllowed = 'move';
        // Firefox requires dataTransfer data to be set
        e.dataTransfer.setData("text/html", e.currentTarget);
    },
    dragEnd: function(e) {

        this.dragged.style.display = "block";
        console.log(this.dragged.parentNode);

        console.log($(this.dragged));
        $(this.dragged).parents('ul').find('.placeholder').remove();
        //this.dragged.parentNode.removeChild(placeholder);
        // Update data
        var data = this.state.data;
        console.log(data);
        var from = Number(this.dragged.dataset.id);
        var to = Number(this.over.dataset.id);
        if(from < to) to--;
        if(this.nodePlacement == "after") to++;
        data.splice(to, 0, data.splice(from, 1)[0]);
        this.setState({data: data});
    },
    dragOver: function(e) {
        e.preventDefault();
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
    render: function() {
        return <ul>
            {this.state.data.map(function(item, i) {
                return (
                    <li
                        onDragOver={this.dragOver}
                        data-id={i}
                        key={i}
                        draggable="true"
                        onDragEnd={this.dragEnd}
                        onDragStart={this.dragStart}
                    >
                        <img src="http://placekitten.com/200/100" alt=""/>
                        {item}
                    </li>
                )
            }, this)}
        </ul>
    }
});

ReactDOM.render(
    <List data={colors} />, document.getElementById('example')
);
