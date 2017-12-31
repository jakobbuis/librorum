/**
 * The Timeable mixins can be used to manage a set of timers. Create a timer
 * using setTimer(milliseconds, callback) and it will fire just a setTimeout is
 * used. Timers are disposed when the component is destroyed.
 */
export default {
    data() {
        return {
            timers: [],
        };
    },

    methods: {
        // Set a new timer
        setTimer(milliseconds, callback) {
            const timer = setTimeout(callback, milliseconds);
            this.timers.push(timer);
        },
    },

    // Clear all timers when the component is destroyed
    beforeDestroy() {
        this.timers.forEach(timer => clearTimeout(this.timers));
        this.timers = [];
    },
};
