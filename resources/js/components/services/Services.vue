<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Service List</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    @click="loadServices"
                                >
                                    <i class="fa fa-sync"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Experience</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="service in services.data"
                                        :key="service.id"
                                    >
                                        <td>{{ service.user.name }}</td>
                                        <td>{{ service.user.email }}</td>
                                        <td>{{ service.product.name }}</td>
                                        <td>
                                            {{
                                                service.product.description
                                                    | truncate(30, "...")
                                            }}
                                        </td>
                                        <td>
                                            {{ service.product.category.name }}
                                        </td>
                                        <td>{{ service.product.price }}</td>
                                        <td>{{ service.years }}</td>
                                        <td>
                                            <a
                                                v-if="$gate.isAdmin()"
                                                href="#"
                                                @click="
                                                    deleteService(service.id)
                                                "
                                            >
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                            <a
                                                v-else
                                                href="#"
                                                @click="
                                                    requestService(service)
                                                "
                                            >
                                                <i class="fas fa-cart-plus green"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination
                                :data="services"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- Modal -->
            <!-- <div
                class="modal fade"
                id="addNew"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNew"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">
                                Create New Service
                            </h5>
                            <h5 class="modal-title" v-show="editmode">
                                Edit Service
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form
                            @submit.prevent="
                                editmode ? updateService() : createService()
                            "
                        >
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select
                                        aria-placeholder="Select a product"
                                        class="form-control"
                                        v-model="form.id"
                                        id="products"
                                        required
                                        @change="setFields"
                                    >
                                        <option
                                            value=""
                                            disabled
                                            selected
                                            hidden
                                        >
                                            Choose a Product
                                        </option>
                                        <option
                                            v-for="(
                                                product, index
                                            ) in products.data"
                                            :key="index"
                                            :value="product.id"
                                        >
                                            {{ product.name }}
                                        </option>
                                    </select>
                                    <has-error
                                        :form="form"
                                        field="category_id"
                                    ></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input
                                        readonly
                                        v-model="form.name"
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('name'),
                                        }"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <input
                                        readonly
                                        v-model="form.category.name"
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('name'),
                                        }"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea
                                        readonly
                                        v-model="form.description"
                                        type="text"
                                        name="description"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('description'),
                                        }"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input
                                        readonly
                                        v-model="form.price"
                                        type="text"
                                        name="price"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('price'),
                                        }"
                                    />
                                </div>

                                <div class="form-group">
                                    <label>Experience (years)</label>
                                    <input
                                        required
                                        v-model="form.experience"
                                        type="number"
                                        name="experience"
                                        class="form-control"
                                        min="0"
                                        step="0.1"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('experience'),
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    v-show="editmode"
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Update
                                </button>
                                <button
                                    v-show="!editmode"
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            editmode: false,
            products: {},
            services: {},
            form: new Form({
                id: "",
                category: "",
                name: "",
                description: "",
                photo: "",
                category_id: "",
                price: "",
                photoUrl: "",
                experience: 0,
                service_id: "",
            }),
            categories: [],
        };
    },
    methods: {
        setFields(value) {
            let id = value.srcElement.value;
            let selectedProduct = this.products.data.filter(
                (elem) => elem.id == id
            )[0];
            console.log(selectedProduct);
            this.form.fill(selectedProduct);
        },
        getResults(page = 1) {
            this.$Progress.start();

            axios
                .get("api/service?page=" + page)
                .then(({ data }) => (this.services = data.data));

            this.$Progress.finish();
        },
        loadProducts() {
            axios
                .get("/api/product")
                .then(({ data }) => (this.products = data.data));
        },
        loadServices() {
            this.$Progress.start();
            axios
                .get("/api/service")
                .then(({ data }) => (this.services = data.data));
            this.$Progress.finish();
        },
        editModal(service) {
            this.editmode = true;
            this.form.reset();
            $("#addNew").modal("show");
            let selectedService = {
                ...service.product,
                experience: service.years,
                service_id: service.id,
            };
            this.form.fill(selectedService);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $("#addNew").modal("show");
        },
        createService() {
            this.$Progress.start();

            this.form
                .post("/api/service")
                .then((data) => {
                    if (data.data.success) {
                        $("#addNew").modal("hide");

                        Toast.fire({
                            icon: "success",
                            title: data.data.message,
                        });
                        this.$Progress.finish();
                        this.loadServices();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Some error occured! Please try again",
                        });

                        this.$Progress.failed();
                    }
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                });
        },
        updateService() {
            this.$Progress.start();
            this.form
                .put(`/api/service/${this.form.service_id}`)
                .then((response) => {
                    // success
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                    //  Fire.$emit('AfterCreate');

                    this.loadServices();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        deleteService(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete("/api/service/" + id)
                        .then(() => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadServices();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                }
            });
        },
        requestService(service) {
            Swal.fire({
                title: "Request a Service!",
                html: `Request <b>${service.product.name}</b> <br>from <b>${service.user.name}</b> <small>(${service.years}Y of experience)</small> <br>for </b>${service.product.price}<i> &#36;</i></b>`,
                showCancelButton: true,
                confirmButtonColor: "#137547",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Request it!",
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .post("/api/serviceRequest")
                        .then(() => {
                            Swal.fire(
                                "Requested!",
                                "Your request hase been sent.",
                                "success"
                            );
                            // Fire.$emit('AfterCreate');
                            // this.loadServices();
                        })
                        .catch((data) => {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                }
            });
        },
    },
    mounted() {},
    created() {
        this.$Progress.start();

        this.loadServices();
        this.loadProducts();

        this.$Progress.finish();
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
    },
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter((i) => {
                return (
                    i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1
                );
            });
        },
    },
};
</script>
