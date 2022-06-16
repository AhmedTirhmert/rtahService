<template>
    <div
        class="modal fade"
        id="feedBackModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="feedBackModal"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Feedbacks for {{ service.product.name }}
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
                        v-if="service.feedback.length  > 0"
                    >
                        <thead>
                            <th>User</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Review</th>
                        </thead>
                        <tbody>
                            <tr
                                v-for="feedback in service.feedback"
                                :key="feedback.id"
                            >
                                <td>{{ feedback.client.name }}</td>
                                <td>{{ feedback.client.email }}</td>
                                <td>
                                    <star-rating
                                        :star-size="20"
                                        read-only
                                        :show-rating="false"
                                        :rating="
                                            feedback.rating
                                        "
                                        :active-color="
                                             feedback.rating > 3 ? '#02c39a' : '#ff3c38'
                                        "
                                    />
                                </td>
                                <td>{{feedback.message}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5 class="text-center col-12" v-else>NO REVIES YET</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from "vue-star-rating";
export default {
    components: {
        StarRating,
    },
    props: ['service'],
};
</script>
