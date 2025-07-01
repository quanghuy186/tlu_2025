@include('components.header')

<title>@yield('title')</title>

@include('components.nav')

@yield('content')

@include('components.footer')


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('custom-js')


<script>
    document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Kiểm tra phần tử tồn tại trước khi thêm event listener
    const openProfileButton = document.getElementById('openProfileModal');
    if (openProfileButton) {
        openProfileButton.addEventListener('click', function(e) {
            e.preventDefault();
            var userModal = new bootstrap.Modal(document.getElementById('userInfoModal'));
            userModal.show();
        });
    }
});
</script>

{{-- teacher --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box button');

        searchButton.addEventListener('click', function() {
            const searchValue = searchInput.value.trim().toLowerCase();
            searchTeachers(searchValue);
        });

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchValue = searchInput.value.trim().toLowerCase();
                searchTeachers(searchValue);
            }
        });

        function searchTeachers(query) {
            console.log('Tìm kiếm giảng viên với từ khóa:', query);
        }

        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const sortBy = document.querySelector('select[class="filter-select"]:nth-child(1)').value;
            const department = document.querySelector('select[class="filter-select"]:nth-child(2)').value;
            const position = document.querySelector('select[class="filter-select"]:nth-child(3)').value;

            console.log('Áp dụng bộ lọc:', { sortBy, department, position });
        }

        const viewButtons = document.querySelectorAll('.view-options button');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const isList = this.querySelector('i').classList.contains('fa-list');
                if (isList) {
                    document.querySelector('.teacher-list').classList.remove('grid-view');
                } else {
                    document.querySelector('.teacher-list').classList.add('grid-view');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewOptionButtons = document.querySelectorAll('.view-options button');
        const studentLists = document.querySelectorAll('.student-list');

        viewOptionButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                studentLists.forEach(list => {
                    if (isGridView) {
                        list.classList.add('grid-view');
                    } else {
                        list.classList.remove('grid-view');
                    }
                });
            });
        });

        const searchInputs = document.querySelectorAll('.search-box input');
        const searchButtons = document.querySelectorAll('.search-box button');

        searchInputs.forEach((input, index) => {
            const button = searchButtons[index];

            input.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch(input.value);
                }
            });

            button.addEventListener('click', function() {
                performSearch(input.value);
            });
        });

        function performSearch(query) {
            query = query.trim().toLowerCase();
        }

        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const filters = {};
            filterSelects.forEach(select => {
                const filterName = select.previousElementSibling.textContent.trim().replace(':', '').toLowerCase();
                filters[filterName] = select.value;
            });

        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewOptionButtons = document.querySelectorAll('.view-options button');
        const unitList = document.querySelector('.unit-list');

        viewOptionButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                if (isGridView) {
                    unitList.classList.add('grid-view');
                } else {
                    unitList.classList.remove('grid-view');
                }
            });
        });

        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box button');

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch(searchInput.value);
            }
        });

        searchButton.addEventListener('click', function() {
            performSearch(searchInput.value);
        });

        function performSearch(query) {
            query = query.trim().toLowerCase();
        }

        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const filters = {};
            filterSelects.forEach(select => {
                const filterName = select.previousElementSibling.textContent.trim().replace(':', '').toLowerCase();
                filters[filterName] = select.value;
            });

        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById('reply-form-' + commentId);
                
                document.querySelectorAll('.reply-form').forEach(form => {
                    if (form.id !== 'reply-form-' + commentId) {
                        form.classList.add('d-none');
                    }
                });
                
                replyForm.classList.toggle('d-none');
                
                if (!replyForm.classList.contains('d-none')) {
                    replyForm.querySelector('textarea').focus();
                }
            });
        });
        
        document.querySelectorAll('.delete-comment-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                    e.preventDefault();
                }
            });
        });
        
        const loadMoreBtn = document.getElementById('loadMoreComments');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const page = parseInt(this.getAttribute('data-page')) + 1;
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang tải...';
                this.disabled = true;
                
                fetch(`/api/forum/post/${postId}/comments?page=${page}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const commentsList = document.querySelector('.comments-list');
                        
                        if (data.data.length > 0) {
                            data.data.forEach(comment => {
                                const commentHtml = createCommentHtml(comment);
                                if (commentsList.querySelector('.text-center')) {
                                    commentsList.innerHTML = '';
                                } else if (commentsList.children.length > 0) {
                                    commentsList.insertAdjacentHTML('beforeend', '<hr class="my-3">');
                                }
                                
                                commentsList.insertAdjacentHTML('beforeend', commentHtml);
                            });
                            
                            this.innerHTML = '<i class="fas fa-sync-alt me-1"></i> Tải thêm bình luận';
                            this.disabled = false;
                            this.setAttribute('data-page', page);
                            
                            if (page >= data.meta.last_page) {
                                this.classList.add('d-none');
                            }
                            
                            attachCommentEventListeners();
                        } else {
                            this.classList.add('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading comments:', error);
                        this.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i> Đã xảy ra lỗi, thử lại';
                        this.disabled = false;
                    });
            });
        }
        
        function createCommentHtml(comment) {
            let avatarHtml = '';
            if (comment.is_anonymous) {
                avatarHtml = `
                    <div class="avatar-circle bg-secondary">
                        <span class="avatar-text"><i class="fas fa-user"></i></span>
                    </div>
                `;
            } else {
                if (comment.user && comment.user.avatar) {
                    avatarHtml = `
                        <img src="${assetPath}${comment.user.avatar}" 
                            alt="${comment.user.name}" class="avatar-img">
                    `;
                } else {
                    avatarHtml = `
                        <div class="avatar-circle bg-primary">
                            <span class="avatar-text">${comment.user ? comment.user.name.charAt(0) : 'U'}</span>
                        </div>
                    `;
                }
            }
            
            let deleteButtonHtml = '';
            if (comment.can_delete) {
                deleteButtonHtml = `
                    <form action="${deleteCommentRoute}" method="POST" class="d-inline delete-comment-form">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="comment_id" value="${comment.id}">
                        <button type="submit" class="btn btn-sm btn-link text-danger delete-comment-btn">
                            <i class="far fa-trash-alt"></i> Xóa
                        </button>
                    </form>
                `;
            }
            
            let replyFormHtml = '';
            if (isAuthenticated) {
                replyFormHtml = `
                    <div class="reply-form mt-3 d-none" id="reply-form-${comment.id}">
                        <form action="${replyCommentRoute}" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="post_id" value="${postId}">
                            <input type="hidden" name="parent_id" value="${comment.id}">
                            <div class="mb-2">
                                <textarea class="form-control form-control-sm" name="content" rows="2" 
                                    placeholder="Viết phản hồi của bạn..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="reply_is_anonymous_${comment.id}" name="is_anonymous">
                                    <label class="form-check-label" for="reply_is_anonymous_${comment.id}">
                                        Phản hồi ẩn danh
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="far fa-paper-plane me-1"></i> Gửi
                                </button>
                            </div>
                        </form>
                    </div>
                `;
            } else {
                replyFormHtml = `
                    <div class="reply-form mt-3 d-none" id="reply-form-${comment.id}">
                        <div class="alert alert-info py-2">
                            <small>
                                <i class="fas fa-info-circle me-1"></i> Vui lòng 
                                <a href="${loginRoute}" class="alert-link">đăng nhập</a> 
                                để phản hồi.
                            </small>
                        </div>
                    </div>
                `;
            }
            
            let repliesHtml = '';
            if (comment.replies && comment.replies.length > 0) {
                let repliesContent = '';
                
                comment.replies.forEach(reply => {
                    let replyAvatarHtml = '';
                    if (reply.is_anonymous) {
                        replyAvatarHtml = `
                            <div class="avatar-circle avatar-circle-sm bg-secondary">
                                <span class="avatar-text"><i class="fas fa-user"></i></span>
                            </div>
                        `;
                    } else {
                        if (reply.user && reply.user.avatar) {
                            replyAvatarHtml = `
                                <img src="${assetPath}${reply.user.avatar}" 
                                    alt="${reply.user.name}" class="avatar-img avatar-img-sm">
                            `;
                        } else {
                            replyAvatarHtml = `
                                <div class="avatar-circle avatar-circle-sm bg-primary">
                                    <span class="avatar-text">${reply.user ? reply.user.name.charAt(0) : 'U'}</span>
                                </div>
                            `;
                        }
                    }
                    
                    let replyDeleteButtonHtml = '';
                    if (reply.can_delete) {
                        replyDeleteButtonHtml = `
                            <div class="reply-actions">
                                <form action="${deleteCommentRoute}" method="POST" class="d-inline delete-comment-form">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="comment_id" value="${reply.id}">
                                    <button type="submit" class="btn btn-sm btn-link p-0 text-danger delete-comment-btn">
                                        <small><i class="far fa-trash-alt"></i> Xóa</small>
                                    </button>
                                </form>
                            </div>
                        `;
                    }
                    
                    repliesContent += `
                        <div class="reply-item mb-2" id="comment-${reply.id}">
                            <div class="d-flex">
                                <div class="me-2">
                                    ${replyAvatarHtml}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 small fw-bold">
                                            ${reply.is_anonymous ? 'Ẩn danh' : (reply.user ? reply.user.name : 'Người dùng')}
                                        </h6>
                                        <small class="text-muted">${reply.created_at_human}</small>
                                    </div>
                                    <div class="reply-content my-1 small">
                                        ${reply.content}
                                    </div>
                                    ${replyDeleteButtonHtml}
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                repliesHtml = `
                    <div class="replies-list mt-3 ps-3 border-start">
                        ${repliesContent}
                    </div>
                `;
            }
            
            return `
                <div class="comment-item" id="comment-${comment.id}">
                    <div class="d-flex">
                        <div class="me-3">
                            ${avatarHtml}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    ${comment.is_anonymous ? 'Ẩn danh' : (comment.user ? comment.user.name : 'Người dùng')}
                                </h6>
                                <small class="text-muted">${comment.created_at_human}</small>
                            </div>
                            <div class="comment-content my-2">
                                ${comment.content}
                            </div>
                            <div class="comment-actions">
                                <button type="button" class="btn btn-sm btn-link ps-0 reply-btn" data-comment-id="${comment.id}">
                                    <i class="far fa-comment-dots"></i> Phản hồi
                                </button>
                                ${deleteButtonHtml}
                            </div>
                            ${replyFormHtml}
                            ${repliesHtml}
                        </div>
                    </div>
                </div>
            `;
        }
        
        function attachCommentEventListeners() {
            document.querySelectorAll('.reply-btn').forEach(button => {
                button.removeEventListener('click', handleReplyClick);
                button.addEventListener('click', handleReplyClick);
            });
            
            document.querySelectorAll('.delete-comment-btn').forEach(button => {
                button.removeEventListener('click', handleDeleteClick);
                button.addEventListener('click', handleDeleteClick);
            });
        }
        
        function handleReplyClick() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('reply-form-' + commentId);
            
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form.id !== 'reply-form-' + commentId) {
                    form.classList.add('d-none');
                }
            });
            
            replyForm.classList.toggle('d-none');
            
            if (!replyForm.classList.contains('d-none')) {
                replyForm.querySelector('textarea').focus();
            }
        }
        
        function handleDeleteClick(e) {
            if (!confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                e.preventDefault();
            }
        }
    });
</script>

{{-- like  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const setupLikeButtons = () => {
        document.querySelectorAll('.like-button').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            const postId = newButton.getAttribute('data-post-id');
            
            fetchLikeInfo(postId, newButton);
            
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                toggleLike(postId, newButton);
            });
        });
    };
    
    const fetchLikeInfo = (postId, button) => {
        fetch(`/forum/post/${postId}/like-info`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCountElement = button.querySelector('.like-count');
                    if (likeCountElement) {
                        likeCountElement.textContent = data.likeCount;
                    }
                    
                    if (data.userLiked) {
                        button.classList.add('liked');
                        button.querySelector('i').classList.remove('far');
                        button.querySelector('i').classList.add('fas');
                    } else {
                        button.classList.remove('liked');
                        button.querySelector('i').classList.remove('fas');
                        button.querySelector('i').classList.add('far');
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching like info:', error);
            });
    };
    
    const toggleLike = (postId, button) => {
        fetch(`/forum/post/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                    throw new Error('Unauthorized');
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const likeCountElement = button.querySelector('.like-count');
                if (likeCountElement) {
                    likeCountElement.textContent = data.likeCount;
                }
                
                if (data.action === 'liked') {
                    button.classList.add('liked');
                    button.querySelector('i').classList.remove('far');
                    button.querySelector('i').classList.add('fas');
                } else {
                    button.classList.remove('liked');
                    button.querySelector('i').classList.remove('fas');
                    button.querySelector('i').classList.add('far');
                }
            }
        })
        .catch(error => {
            console.error('Error toggling like:', error);
        });
    };
    setupLikeButtons();
    
    window.setupLikeButtons = setupLikeButtons;
});
</script>

</body>
</html>
