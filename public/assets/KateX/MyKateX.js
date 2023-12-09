window.onload = function () {
    const allMath = document.querySelectorAll('.katex');
    const a = document.querySelectorAll('.katex .katex');
    const loop = [];
    allMath.forEach(e=>{
        let bool = true;
        a.forEach(j=>{
            if(e === j){
                bool = false;
            }
        })
        if(bool){
            loop.push(e);
        }
    })
    loop.forEach(function(math) {
        console.log(math)
        try {
            let textContent = math.textContent;
            katex.render(textContent, math, { throwOnError: false });
        } catch (error) {
            console.log(error);
        }
    });
}