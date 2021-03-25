import '@/bootstrap'
// Create axios instance
const service = window.axios.create({
  baseURL: process.env.MIX_BASE_API,
  timeout: 10000, // Request timeout
})


// Request intercepter
service.interceptors.request.use(
  config => {
    // const token = isLogged()
    // if (token) {
    //   config.headers['Authorization'] = 'Bearer ' + isLogged() // Set JWT token
    // }
    return config
  },
  error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
  }
)

// response pre-processing
service.interceptors.response.use(
  response => {
    // if (response.headers.authorization) {
    //   setLogged(response.headers.authorization)
    //   response.data.token = response.headers.authorization
    // }

    return response.data
  },
  error => {
    let message = error.message
    if (error.response.data && error.response.data.errors) {
      message = error.response.data.errors
    } else if (error.response.data && error.response.data.error) {
      message = error.response.data.error
    }

    // swal.fire({
    //   toast: true,
    //   position: 'top',
    //   timer: 2000,
    //   icon: 'error',
    //   title: message,
    //   showConfirmButton: false,
    // })

    toast.fire(message, '', 'error')
    return null
    // return Promise.reject(error)
  }
)

export default service
