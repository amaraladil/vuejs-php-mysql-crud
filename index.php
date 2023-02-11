<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js with PHP & MySQL</title>
    <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
    <link rel="stylesheet" href="css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
</head>
<body>
    <div class='container' id='vueapp'>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <b-form-select v-model="activeCategory" :options="options" v-on:change="getDocuments"></b-form-select>
                    </div>
                    <div class="col d-flex">
                        <input id="btnAdd" type="button" class="btn btn-success ml-auto low-size" @click="openModal" value="Add New Document" v-bind:disabled="activeCategory == null" />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Document Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tr v-for="document in currentDocuments">
                            <td>{{ document.name }}</td>
                            <td>{{ document.created_at }}</td>
                            <td>{{ document.updated_at }}</td>
                            <td><button type="button" name="edit" class="btn btn-primary btn-sm" @click="fetchDocument(document.id)">Edit</button></td>
                            <td><button type="button" name="delete" class="btn btn-danger btn-sm" @click="deleteDocument(document.id)">Delete</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer"> Created by Amar Al-Adil </div>
        </div>
        <transition name="model">
            <div v-if="myModel" class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ dynamicTitle }}</h4>
                                <button type="button" class="close" @click="myModel=false"><span aria-hidden="true">&times;</span></button>  
                            </div>
                            <div class="modal-body">
                                <form v-on:submit.prevent >
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" class="form-control" v-model="app.options.find(val => val.value == app.activeCategory).text" disabled/>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Document Name</label>
                                        <input type="text" class="form-control" v-model="formDocumentName" />
                                    </div>
                                    <div>
                                        <input type="submit" class="btn btn-success btn-sm btn-block" v-model="actionButton" @click="submitDocument" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
    <script src="js/app.js"></script>
</body>
</html> 
