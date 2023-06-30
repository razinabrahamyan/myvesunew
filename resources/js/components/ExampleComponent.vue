<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            // Echo.private(`survey.${survey_id}`)
            //     .listen('MessagePushed', (e) => {
            //         console.log(e.update);
            //     });
            listenForBroadcast(survey_id)
            {

                Echo.join('survey.' + survey_id)

                    .here((users) => {

                        this.users_viewing = users;

                        this.$forceUpdate();

                    })

                    .joining((user) => {

                        if (this.checkIfUserAlreadyViewingSurvey(user)) {

                            this.users_viewing.push(user);

                            this.$forceUpdate();

                        }

                    })

                    .leaving((user) => {

                        this.removeViewingUser(user);

                        this.$forceUpdate();

                    });

            }
        }

}
</script>
