/*
    @file name: app.js
    @description: Vue, handles the front end javascript for the web page
    @author: Amar Al-Adil
*/
var app = new Vue({
    el: '#vueapp',
    data: {
        categories: [],         // stores all of categories
        activeCategory: null,   // selected category from dropdown
        options: [],            // sets the options for the dropdown
        currentDocuments: [],   // stores the documents within the category
        myModel:false,          // boolean for if to show the modal, default false at start
        actionButton:'Insert',  // the submit button for modal, default insert
        dynamicTitle:'Add Data',// the title for modal, defualt Add Data
        formDocumentName: '',   // Modal's form document name
        formDocumentId: '',     // Modal ID when selected
    },
    //Initializes functions once ready
    mounted: function () {
        console.log('Initialized Vue!')
        this.getDropDown()
    },
    methods: {
        // getDropDown - gets all of the categories from database
        getDropDown: function() {
            axios.get('api/categories.php')
            .then(function (response) {
                app.categories = response.data;

                // Setup the options select field for vue
                app.categories.map(function(row) {
                    app.options.push({ value: row.id, text: row.category});
                });

                // Initializes the first Category as the selected option
                // This is currently commented to follow #3 of the instructions
                // app.activeCategory = app.options[0].value 

                app.getDocuments()
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        // getDocuments - gets all the document from the selected category in dropdown option
        getDocuments: function() {
            // check if add button is disabled
            if (this.btnDisabled) {
                this.btnDisabled = false
            }
            axios.get('api/documents.php?category_id=' + app.activeCategory)
            .then(function (response) {
                //sets the current shown documents
                app.currentDocuments = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        // openModal - sets up the modal when click occurs to add document
        openModal:function(){
            if (this.activeCategory != null) {
                this.formDocumentName = '';
                this.actionButton = "Insert";
                this.dynamicTitle = "Add Data";
                this.myModel = true;
            }
        },
        // resetForm - empties the fill in variables
        resetForm: function(){
            this.formDocumentName = '';
            this.formDocumentId = '';
        },
        // submitDocument - Submits the form's data to the database
        submitDocument: function() {
            // Document name cannot be empty
            if (this.formDocumentName == ''){
                alert("Document cannot be empty");
            } else {
                let formData = new FormData();
                formData.append('name', this.formDocumentName);
                formData.append('id', this.formDocumentId);
                formData.append('submitAction', this.actionButton);

                axios({
                    method: 'post',
                    url: 'api/documents.php?category_id=' + app.activeCategory,
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then(function (response) {
                    // Reinitializes current documents
                    app.getDocuments();
                    app.resetForm();
                    app.myModel = false;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        // fetchDocument - Fetch document infomation for editing purposes
        fetchDocument: function(id) {
            this.formDocumentName = this.currentDocuments.find(val => val.id == id).name
            this.dynamicTitle = 'Edit Data';
            this.actionButton = 'Update';
            this.myModel = true;
            this.formDocumentId = id;
        },
        // deleteDocument - delete the selected document
        deleteDocument:function(documentId){
            // Precaution for user if clicking on delete
            if(confirm("Are you sure you want to remove this Document?")) {
                let formData = new FormData();
                formData.append('name', this.formDocumentName);
                formData.append('id', documentId);
                formData.append('submitAction', 'delete');

                axios({
                    method: 'post',
                    url: 'api/documents.php?category_id=' + app.activeCategory,
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then(function (response) {
                    //Remove the document from Web Page
                    app.currentDocuments = app.currentDocuments.filter(val => val.id != documentId)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
});