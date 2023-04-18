addEventListener("DOMContentLoaded", (event) => {

    const textCount = document.querySelectorAll('text').length;
    const pathLength = document.querySelector('#circle').getTotalLength();
    let totalTextLength = 0;
    
    for (let i = 1; i <= textCount; i++) {
        const textPath = document.querySelector(`#textPath${i}`);
        const text = textPath.textContent;
        const textLength = textPath.getComputedTextLength();
        totalTextLength += textLength;
    }
    
    const gapLength = (pathLength - totalTextLength) / textCount;
    
    let currentOffset = 0;
    
    for (let i = 1; i <= textCount; i++) {
        const textPath = document.querySelector(`#textPath${i}`);
        const text = textPath.textContent;
        const textLength = textPath.getComputedTextLength();
        textPath.setAttribute('startOffset', currentOffset);
        currentOffset += textLength + gapLength;
    }
});