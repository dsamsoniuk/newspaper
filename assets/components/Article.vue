<template>
    <div>
        <p>This isArttttt {{count}} - {{msg}} - {{answer}}</p>
        <button @click="increment">Count</button>
        <ul>
            <li v-for="item in items">
  {{ item.message }}
</li>
        </ul>
    </div>
 </template>
 <script>
    import Helper from '../helper/CountHelper';

    export default {
        name: "example",
        data() {
            return {
                count:2,
                msg:'msg',
                items: [{ message: 'Foo' }, { message: 'Bar' }],
                answer: 'aaaaa'
            }
        },
        methods: {
            increment() {
                let val = document.getElementById('app').getAttribute('data-url')
                this.msg = val + Helper.add(2,this.count)
                this.count++
                this.getAnswer()
            },
            async getAnswer() {
                this.answer = 'Thinking...'
                try {
                    const res = await fetch('https://yesno.wtf/api')
                    this.answer = (await res.json()).answer
                } catch (error) {
                    this.answer = 'Error! Could not reach the API. ' + error
                }
            }
        },
        mounted() {
            console.log(`The initial count is ${this.count}.`)
        }
    }
 </script>

 <style scoped>
 </style>