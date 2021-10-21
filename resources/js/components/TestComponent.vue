<template>
    <div class="container">
        <div class="row justify-content-center">
            <form v-on:submit.prevent="addAnswer(currentAnswer)">
                <div class="alert alert-secondary" role="alert">
                    Seleccione la respuesta correcta para la siguiente pregunta
                </div>
                <p class="text-start" v-text="currentQuestion.content"></p>
                <div class="form-check" v-for="answer in currentQuestion.answers">
                    <input class="form-check-input" type="radio" name="answer" v-on:change="setCurrentAnswer(answer.id)"
                           v-bind:id="answer.id">
                    <label class="form-check-label" v-text="answer.content">
                    </label>
                </div>
                <hr/>
                <button type="submit" class="btn btn-primary">Enviar respuesta</button>
                <a href="https://radiant-headland-70565.herokuapp.com/" class="btn btn-danger">Pedir otro examen</a>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        axios.get('https://radiant-headland-70565.herokuapp.com/api/v1/questions')
            .then((response) => {
                this.questions = response.data.data
                this.currentQuestion = response.data.data[0]
            })
            .catch((error) => console.log(error));
    },
    data() {
        return {
            questions: [],
            currentQuestion: [],
            answers: [],
            currentAnswer: 0,
            questionIndex: 0
        }
    },
    methods: {
        getQuestions() {
            console.log('Component mounted.');
        },
        setCurrentAnswer(currentAnswer) {
            this.currentAnswer = currentAnswer
        },
        addAnswer(answer) {
            if (answer === 0) {
                return alert('Debes marcar al menos una respuesta para cada pregunta')
            }

            this.answers.push(answer)
            this.questionIndex++

            if (this.questionIndex >= this.questions.length) {
                return this.checkAnswers()
            }

            this.currentQuestion = this.questions[this.questionIndex]
            this.currentAnswer = 0
        },
        checkAnswers() {
            const params = {
                answers: this.answers
            }
            axios.post('https://radiant-headland-70565.herokuapp.com/api/v1/test-result', params)
                .then((response) => {
                    alert('Preguntas correctas: ' + response.data.data.answers.correct + '\n' + 'Preguntas incorrectas: ' + response.data.data.answers.incorrect)
                })
                .catch((error) => console.log(error));
        }
    }
}
</script>
