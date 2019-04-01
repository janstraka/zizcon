var placeholder = document.createElement("li");
placeholder.className = "placeholder";

var basePath = '/'; // fiksme

var List = React.createClass({

    timer: 500,

    getInitialState: function() {
        //return {data: this.props.data};
        return {data: []};
    },
    componentDidMount: function(){

        // When the component loads, send a jQuery AJAX request
        var self = this;

        // API endpoint for Instagram's popular images for the day

        //var url = 'https://api.instagram.com/v1/media/popular?client_id=642176ece1e7445e99244cec26f4de1f&callback=?';

        $.getJSON(HANDLE_FIND_ALL, function(result){
            console.log(result);
            if(!result){
                return;
            }

            var data = result.map(function(file){
                return {
                    id: file.id,
                    path: file.path,
                    title: file.title,
                };

            });

            // Update the component's state. This will trigger a render.
            // Note that this only updates the pictures property, and does
            // not remove the favorites array.

            self.setState({ data: data });

        });

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

        this.sortIt(data);

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
    sortIt: function(data){
        console.log(data);

        var ids = '';
        data.map(function(item, i){
            ids += item.id + ',';
        });

        $.get(HANDLE_SORT.replace('_order_', ids));
    },
    changeTitle: function(e){

        var $el = $(e.target),
            id = $el.data('dbid'),
            title = $el.val();


        this.state.data.map(function(item, i) {
            if(item.id == id){
                item.title = title;
            }
        });
        this.forceUpdate();


        var delay = 750;
        clearTimeout(this.timer);
        this.timer = setTimeout(function() {
            $.get(HANDLE_CHANGE_TITLE.replace('_id_file_', id).replace('_title_', title));
        }, delay );

    },



    // prevent form from submitting; we are going to capture the file contents
    handleSubmit: function(e) {
        e.preventDefault();
    },

    // when a file is passed to the input field, retrieve the contents as a
    // base64-encoded data URI and save it to the component's state
    handleFile: function (e) {
        var self = this;

        let imageFormData = new FormData();
        $.each(e.target.files, function(key, value) {
            imageFormData.append('imageFile[]', e.target.files[key]);
        });

        $.ajax({
            url: HANDLE_UPLOAD,
            data: imageFormData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                self.componentDidMount();
            }
        });
        e.preventDefault()
    },

    deleteImage: function(id, e){
        var self = this;
        if(confirm('Opravdu?')){

            $.get(HANDLE_DELETE.replace('_id_file_', id)).done(function(){
                self.componentDidMount();
            });
        }

        e.preventDefault();
    },

    render: function() {
        return <ul>
            <form onSubmit={this.handleSubmit} encType="multipart/form-data">
                <div className="form-group">
                   <input className="btn-file" type="file" multiple onChange={this.handleFile} />
                </div>
            </form>

            {this.state.data.map(function(item, i) {

                return (
                    <li
                        onDragOver={this.dragOver}
                        data-id={i}
                        key={i}
                        data-dbid={item.id}
                        draggable="true"
                        onDragEnd={this.dragEnd}
                        onDragStart={this.dragStart}
                    >

                        <img src={basePath + item.path} width="100" alt="" />
                        <input  placeholder="Popis fotografie..." ref="text" onChange={this.changeTitle} value={item.title} data-dbid={item.id} />

                        <a className="button" href="#" data-dbid={item.id} onClick={this.deleteImage.bind(this, item.id)}><i className="fa fa-trash-o"></i></a>


                    </li>
                )
            }, this)}
        </ul>
    }
});

ReactDOM.render(
    <List />, document.getElementById('gallery-list')
);
