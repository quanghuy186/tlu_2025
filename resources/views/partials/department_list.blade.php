        @foreach ($departments as $department)
                <div class="unit-item">
                    @if($department->manager)
                    <div class="d-flex align-items-center">
                        @if($department->manager->avatar)
                            <img src="{{ asset('storage/avatars/'.$department->manager->avatar) }}" 
                                alt="{{ $department->manager->name }}" style="border-radius : 50%" 
                                class="unit-logo">
                        @else
                            <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-muted"></span>
                @endif
                    <div class="unit-info">
                        <div class="unit-name">{{$department->name}}</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>
                                    Trưởng đơn vị: 
                                    @if ($department->manager && $department->manager->name)
                                        {{ $department->manager->name }}
                                    @endif
                                </span>
                                
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 45</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#unitDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach