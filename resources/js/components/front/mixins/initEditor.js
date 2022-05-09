export default {
    methods: {
        initEditor(selector,key,cb) {
            const self = this
            ClassicEditor
              // Note that you do not have to specify the plugin and toolbar configuration — using defaults from the build.
              .create(document.querySelector(selector), {
                simpleUpload: {
                  // The URL that the images are uploaded to.
                  uploadUrl: "/api/ckeditor/upload-image",
      
                  // Enable the XMLHttpRequest.withCredentials property.
                  withCredentials: true,
      
                  // Headers sent along with the XMLHttpRequest to the upload server.
                  headers: {
                    "X-CSRF-TOKEN": document
                      .querySelector('meta[name="csrf-token"]')
                      .getAttribute("content"),
                    Accept: "application/json",
                  },
                },
              })
              .then((editor) => {
                console.log("Editor was initialized", editor);
                if (key.indexOf('.') > -1) {
                    let keys = key.split('.')
                    let obj = self[keys[0]]
                    for (let i = 1; i < keys.length; i++) {
                        if (i == keys.length - 1) {
                            obj[keys[i]] = editor
                        } else {
                            obj = obj[keys[i]]
                        }
                    }
                    
                } else {
                    self[key] = editor
                }
                cb()
              })
              .catch((error) => {
                console.error(error.stack);
              });
        },
    }
}