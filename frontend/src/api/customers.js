import axios from 'axios'

const getCustomers = async () => {
    let result = ''

    try {
        result = await axios.get('/customers')
        if (result.status === 200) {
            return {
                customers: result.data,
            }
        }
    } catch (e) {
        console.log(e)
    }

    return result
}

export {
    getCustomers
}