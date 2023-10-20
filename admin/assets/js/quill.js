function editor() {
  var toolbarOptions = [
    [{
      'header': [1, 2, 3, 4, 5, 6, false]
    }],
    [{
      'font': []
    }],
    ['bold', 'italic', 'underline', 'code'],
    ['strike', 'blockquote', 'link'],
    [{
      'list': 'ordered'
    }, {
      'list': 'bullet'
    }],
    [{
      'script': 'sub'
    }, {
      'script': 'super'
    }],
    [{
      'color': []
    }, {
      'background': []
    }],
    [{
      'align': []
    }]
  ];
  var quill = new Quill('#description', {
    debug: 'info',
    modules: {
      toolbar: {
        container: toolbarOptions,
        handlers: {
          image: imageHandler
        }
      }
    },
    theme: 'snow',
    placeholder: "Write your description...",
    readOnly: false,
  });

  function imageHandler() {
    var range = this.quill.getSelection();
    var value = prompt('Paste the image address url here.');
    if (value) {
      this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
    }
  }
}
