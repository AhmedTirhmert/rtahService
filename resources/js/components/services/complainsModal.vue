<template>
    <div
        class="modal fade"
        id="complainsModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="complainsModal"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Complains for <b>{{ service.product.name }}</b>
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
                <div class="modal-body">
                    <table
                        class="table table-stripped table-bordered"
                        v-if="service.complains.length > 0"
                    >
                        <thead>
                            <th>User</th>
                            <th>Email</th>
                            <th>Message</th>
                        </thead>
                        <tbody>
                            <tr
                                v-for="complain in service.complains"
                                :key="complain.id"
                            >
                                <td>{{ complain.client.name }}</td>
                                <td>{{ complain.client.email }}</td>
                                <td>{{ complain.message }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5 class="text-center col-12" v-else>
                        NO COMPLAINS FOR THIS ONE
                    </h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: ["service"],
};
</script>
