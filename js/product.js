let preveiwmain-container = document.querySelector('.products-preview');
let previewBox = preveiwmain-container.querySelectorAll('.preview');

document.querySelectorAll('.product-row .product').forEach(product =>{
  product.onclick = () =>{
    preveiwmain-container.style.display = 'flex';
    let name = product.getAttribute('data-name');
    previewBox.forEach(preview =>{
      let target = preview.getAttribute('data-target');
      if(name == target){
        preview.classList.add('active');
      }
    });
  };
});

previewBox.forEach(close =>{
  close.querySelector('.fa-times').onclick = () =>{
    close.classList.remove('active');
    preveiwmain-container.style.display = 'none';
  };
});